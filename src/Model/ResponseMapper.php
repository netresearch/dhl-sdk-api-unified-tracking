<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\Group\Tracking\Model\Tracking\TrackResponse;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\TrackingResponseType;

class ResponseMapper
{
    public function map(TrackingResponseType $response): TrackResponseInterface
    {
        // @TODO Create mapper
        return new TrackResponse($response);
    }
}
