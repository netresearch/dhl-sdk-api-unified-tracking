<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\DeliveryTimeFrameInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\EstimatedDeliveryInterface;

class EstimatedDelivery implements EstimatedDeliveryInterface
{
    public function __construct(
        private readonly \DateTime $dateTime,
        private readonly ?DeliveryTimeFrameInterface $timeFrame,
        private readonly string $timeRemark = ''
    ) {
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function getTimeFrame(): ?DeliveryTimeFrameInterface
    {
        return $this->timeFrame;
    }

    public function getTimeRemark(): string
    {
        return $this->timeRemark;
    }
}
