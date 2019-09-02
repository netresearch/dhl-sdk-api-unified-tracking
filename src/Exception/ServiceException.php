<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Exception;

use Http\Client\Exception;

/**
 * Class ServiceException
 *
 * Generic SDK exception, can be used to catch any communication exception in
 * cases where the exact type does not matter.
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
abstract class ServiceException extends \Exception implements Exception
{
}
