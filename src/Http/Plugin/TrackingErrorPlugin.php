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
     *
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
     * @throws AuthenticationErrorException
     * @throws DetailedErrorException
     * @throws \JsonException
     */
    private function handleDetailedError(int $statusCode, RequestInterface $request, ResponseInterface $response): void
    {
        $responseJson = (string) $response->getBody();
        $responseData = \json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR) ?: [];
        $errorMessage = $this->formatErrorMessage($statusCode, $responseData);

        if ($statusCode === self::HTTP_UNAUTHORIZED) {
            throw new AuthenticationErrorException($errorMessage, $request, $response);
        }

        // 400, 404, 429 - throw bad request errors
        // 503 - throw service unavailable error
        throw new DetailedErrorException($errorMessage, $request, $response);
    }

    /**
     * Handles all client/server errors when response does not contain body with error message.
     *
     * @throws AuthenticationErrorException
     * @throws HttpException
     */
    private function handleError(int $statusCode, RequestInterface $request, ResponseInterface $response): void
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
     * @param callable $next Next middleware in the chain, the request is passed as the first argument
     * @param callable $first First middleware in the chain, used to restart a request
     * @return Promise<ResponseInterface> Resolves a PSR-7 Response or fails with a Http\Client\Exception
     *                                    (The same as HttpAsyncClient).
     * @throws \JsonException
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $promise = $next($request);

        // a response is available. transform error responses into exceptions
        $fnFulfilled = function (ResponseInterface $response) use ($request): ResponseInterface {
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
