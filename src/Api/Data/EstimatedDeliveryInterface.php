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
 */
interface EstimatedDeliveryInterface
{
    /**
     * Estimated delivery time
     */
    public function getDateTime(): \DateTime;

    /**
     * Estimated delivery time frame
     */
    public function getTimeFrame(): ?DeliveryTimeFrameInterface;

    /**
     * Human-readable additional information regarding the delivery time
     */
    public function getTimeRemark(): string;
}
