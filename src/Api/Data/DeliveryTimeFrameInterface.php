<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface DeliveryTimeFrameInterface
 *
 * Describing possible timeframes in regard to delivery times
 *
 * @api
 */
interface DeliveryTimeFrameInterface
{
    /**
     * Earliest possible delivery time
     */
    public function getStart(): \DateTime;

    /***
     * Latest possible delivery time
     */
    public function getEnd(): \DateTime;
}
