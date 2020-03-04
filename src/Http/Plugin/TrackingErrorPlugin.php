<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Http\Plugin;

use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationErrorException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedErrorException;
use Http\Client\Common\Plugin;
use Http\Client\Exception\HttpException;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TrackingErrorPlugin
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
final class TrackingErrorPlugin implements Plugin
{
    /**
     * HTTP response codes
     */
    private const HTTP_UNAUTHORIZED = 401;

    /**
     * Returns TRUE if the response contains a detailed error response.
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    private function isDetailedErrorResponse(ResponseInterface $response): bool
    {
        $contentTypes = $response->getHeader('Content-Type');
        return $contentTypes && ($contentTypes[0] === 'application/json');
    }

    /**
     * Returns the formatted error message.
     *
     * @see https://tools.ietf.org/html/rfc7807
     *
     * @param int $statusCode The response status code
     * @param string[] $responseData The response data in application/problem+json format
     * @return string
     */
    private function formatErrorMessage(int $statusCode, array $responseData): string
    {
        $errorMessage = $responseData['type'] ?? '';
        $errorMessage .= ' Title: %s, Details: %s, Status: %d';
        $errorTitle = $responseData['title'] ?? '';
        $errorDetail = $responseData['detail'] ?? '';
        $instance = $responseData['instance'] ?? '';
        if (!empty($instance)) {
            $errorMessage .= ' Instance: ' . $instance;
        }

        return sprintf(
            $errorMessage,
            $errorTitle,
            $errorDetail,
            $statusCode
        );
    }

    /**
     * Handles client/server errors with error messages in response body.
     *
     * @param int $statusCode
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws AuthenticationErrorException
     * @throws DetailedErrorException
     */
    private function handleDetailedError(int $statusCode, RequestInterface $request, ResponseInterface $response)
    {
        $responseJson = (string) $response->getBody();
        $responseData = \json_decode($responseJson, true);
        $errorMessage = $this->formatErrorMessage($statusCode, $responseData);

        if ($statusCode === self::HTTP_UNAUTHORIZED) {
            throw new AuthenticationErrorException($errorMessage, $request, $response);
        }

        // 400, 404, 429 - throw bad request errors
        // 503 - throw service unavailable error
        throw new DetailedErrorException($errorMessage, $request, $response);
    }

    /**
     * Handles all client/server errors when response does not contains body with error message.
     *
     * @param int $statusCode
     * @param RequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     *
     * @throws AuthenticationErrorException
     * @throws HttpException
     */
    private function handleError(int $statusCode, RequestInterface $request, ResponseInterface $response)
    {
        if ($statusCode === self::HTTP_UNAUTHORIZED) {
            throw new AuthenticationErrorException(
                'Authentication failed. Please check your access credentials.',
                $request,
                $response
            );
        }

        // 400, 404, 429 - throw bad request errors
        // 503 - throw service unavailable error
        throw new HttpException($response->getReasonPhrase(), $request, $response);
    }

    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @param RequestInterface $request
     * @param callable $next Next middleware in the chain, the request is passed as the first argument
     * @param callable $first First middleware in the chain, used to to restart a request
     *
     * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient).
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        /** @var Promise $promise */
        $promise = $next($request);

        // a response is available. transform error responses into exceptions
        $fnFulfilled = function (ResponseInterface $response) use ($request) {
            $statusCode = $response->getStatusCode();

            if ($statusCode >= 400 && $statusCode < 600) {
                $this->isDetailedErrorResponse($response)
                    ? $this->handleDetailedError($statusCode, $request, $response)
                    : $this->handleError($statusCode, $request, $response);
            }

            // no error
            return $response;
        };

        return $promise->then($fnFulfilled);
    }
}
