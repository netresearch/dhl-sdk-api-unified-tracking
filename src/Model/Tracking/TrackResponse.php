<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\TrackingResponseType;

class TrackResponse implements TrackResponseInterface
{
    /**
     * @var TrackingResponseType
     */
    private $originResponse;

    /**
     * TrackResponse constructor.
     *
     * @param TrackingResponseType $originResponse
     */
    public function __construct(TrackingResponseType $originResponse)
    {
        $this->originResponse = $originResponse;
    }

    /**
     * @return TrackingResponseType
     */
    public function getOriginResponse(): TrackingResponseType
    {
        return $this->originResponse;
    }

}
