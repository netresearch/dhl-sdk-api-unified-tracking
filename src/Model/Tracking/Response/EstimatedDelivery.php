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
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var DeliveryTimeFrameInterface|null
     */
    private $timeFrame;

    /**
     * @var string
     */
    private $timeRemark;

    public function __construct(
        \DateTime $dateTime,
        ?DeliveryTimeFrameInterface $timeFrame,
        string $timeRemark = ''
    ) {
        $this->dateTime = $dateTime;
        $this->timeFrame = $timeFrame;
        $this->timeRemark = $timeRemark;
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
