<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Exception;

/**
 * Class ServiceException
 *
 * Generic SDK exception, can be used to catch any SDK exception
 * in cases where the exact type does not matter. Exception messages
 * are suitable for logging.
 *
 * @api
 */
class ServiceException extends \Exception
{
}
