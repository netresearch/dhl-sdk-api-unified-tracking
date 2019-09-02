<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Exception;

/**
 * Class ClientException
 *
 * Exception that is caused by bad request or authentication data (HTTP status 4xx)
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ClientException extends ServiceException
{
    /**
     * Create client exception
     *
     * @param \Exception $exception
     * @return ClientException
     */
    public static function create(\Exception $exception)
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }
}
