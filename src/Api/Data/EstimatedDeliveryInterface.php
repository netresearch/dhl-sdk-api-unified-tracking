<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface EstimatedDeliveryInterface
 *
 * Describing information regarding the estimated delivery data
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface EstimatedDeliveryInterface
{
    /**
     * Estimated delivery time
     *
     * @return \DateTime
     */
    public function getDateTime(): \DateTime;

    /**
     * Estimated delivery time frame
     *
     * @return DeliveryTimeFrameInterface|null
     */
    public function getTimeFrame(): ?DeliveryTimeFrameInterface;

    /**
     * Human readable additional information regarding the delivery time
     *
     * @return string
     */
    public function getTimeRemark(): string;
}
