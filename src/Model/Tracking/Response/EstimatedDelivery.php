<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking\Response;

use Dhl\Sdk\GroupTracking\Api\Data\DeliveryTimeFrameInterface;
use Dhl\Sdk\GroupTracking\Api\Data\EstimatedDeliveryInterface;

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

    /**
     * EstimatedDelivery constructor.
     *
     * @param \DateTime $dateTime
     * @param DeliveryTimeFrameInterface|null $timeFrame
     * @param string $timeRemark
     */
    public function __construct(
        \DateTime $dateTime,
        DeliveryTimeFrameInterface $timeFrame = null,
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

    public function getTimeFrame()
    {
        return $this->timeFrame;
    }

    public function getTimeRemark(): string
    {
        return $this->timeRemark;
    }
}