<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\AddressInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentEventInterface;

class ShipmentEvent implements ShipmentEventInterface
{
    public function __construct(
        private readonly \DateTime $timeStamp,
        private readonly string $statusCode = '',
        private readonly string $status = '',
        private readonly string $description = '',
        private readonly string $remark = '',
        private readonly string $nextSteps = '',
        private readonly ?AddressInterface $location = null
    ) {
    }

    public function getTimeStamp(): \DateTime
    {
        return $this->timeStamp;
    }

    public function getLocation(): ?AddressInterface
    {
        return $this->location;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRemark(): string
    {
        return $this->remark;
    }

    public function getNextSteps(): string
    {
        return $this->nextSteps;
    }
}
