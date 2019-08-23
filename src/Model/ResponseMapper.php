<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;

class ResponseMapper
{
    public function map(\JsonSerializable $response): TrackResponseInterface
    {
        return null;
    }

}
