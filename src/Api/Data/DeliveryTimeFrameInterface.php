<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface DeliveryTimeFrameInterface
 *
 * Describing possible timeframes in regards to delivery times
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface DeliveryTimeFrameInterface
{
    /**
     * Earliest possible delivery time
     *
     * @return \DateTime
     */
    public function getStart(): \DateTime;

    /***
     * Latest possible delivery time
     *
     * @return \DateTime
     */
    public function getEnd(): \DateTime;
}
