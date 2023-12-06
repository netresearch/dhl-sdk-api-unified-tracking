<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Exception;

use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ServiceExceptionFactory
 *
 * A service exception factory to create specific exception instances.
 */
class ServiceExceptionFactory
{
    /**
     * Create a service exception.
     */
    public static function create(\Throwable $exception): ServiceException
    {
        return new ServiceException($exception->getMessage(), $exception->getCode(), $exception);
    }

    /**
     * Create a HTTP client exception.
     */
    public static function createServiceException(ClientExceptionInterface $exception): ServiceException
    {
        if (!$exception instanceof \Throwable) {
            return new ServiceException('Unknown exception occurred', 0);
        }

        return self::create($exception);
    }

    /**
     * Create a detailed service exception.
     */
    public static function createDetailedServiceException(\Throwable $exception): DetailedServiceException
    {
        return new DetailedServiceException($exception->getMessage(), $exception->getCode(), $exception);
    }

    /**
     * Create an authentication exception.
     */
    public static function createAuthenticationException(\Throwable $exception): AuthenticationException
    {
        return new AuthenticationException($exception->getMessage(), $exception->getCode(), $exception);
    }
}
