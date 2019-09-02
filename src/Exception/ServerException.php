<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Exception;

/**
 * Class ServerException
 *
 * Exception that is caused by a server error (HTTP status 5xx)
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ServerException extends ServiceException
{
    /**
     * Create server exception when no response is available
     *
     * @param \Exception $exception
     * @return ClientException
     */
    public static function create(\Exception $exception)
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }

}