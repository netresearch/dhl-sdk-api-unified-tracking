<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Exception;

use Http\Client\Exception\HttpException;

/**
 * A detailed HTTP exception.
 *
 * @author Rico Sonntag <rico.sonntag@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class DetailedErrorException extends HttpException
{
}
