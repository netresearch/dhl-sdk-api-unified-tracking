<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Http\Plugin;

use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\Exception\ServerErrorException;
use Http\Client\Common\Plugin;
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

            if ($statusCode >= 400 && $statusCode < 500) {
                $responseJson = (string) $response->getBody();
                if (empty($responseJson) || !\in_array($statusCode, [400, 401, 404, 429], true)) {
                    // throw generic client exception
                    throw new ClientErrorException($response->getReasonPhrase(), $request, $response);
                }

                $responseData = \json_decode($responseJson, true);
                if (\in_array($statusCode, [400, 401, 404, 429], true)) {
                    // throw bad request error
                    throw new ClientErrorException(
                        $this->formatErrorMessage($statusCode, $responseData),
                        $request,
                        $response
                    );
                }
            } elseif ($statusCode >= 500 && $statusCode < 600) {
                $responseJson = (string) $response->getBody();
                if (empty($responseJson) || !\in_array($statusCode, [500, 503], true)) {
                    // throw generic server exception
                    throw new ServerErrorException($response->getReasonPhrase(), $request, $response);
                }

                $responseData = \json_decode($responseJson, true);
                if ($statusCode === 500) {
                    // throw internal service error
                    $message = $responseData['type'] ?? $responseData['title'];
                    throw new ServerErrorException($message, $request, $response);
                }

                if ($statusCode === 503) {
                    // throw service unavailable error
                    throw new ServerErrorException(
                        $this->formatErrorMessage($statusCode, $responseData),
                        $request,
                        $response
                    );
                }
            }

            // no error
            return $response;
        };

        return $promise->then($fnFulfilled);
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
}
