<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Api\Data;

/**
 * Interface ShipmentEventInterface
 *
 * Describing events in shipment handling
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link http://www.netresearch.de/
 */
interface ShipmentEventInterface
{
    /**
     * Time on which the event happened
     *
     * @return \DateTime
     */
    public function getTimeStamp(): \DateTime;

    /**
     * Location information to the event
     *
     * @return AddressInterface|null
     */
    public function getLocation();

    /**
     * High level status group, one of:
     * - pre-transit
     * - transit
     * - delivered
     * - failure
     * - unknown
     *
     * @return string
     */
    public function getStatusCode(): string;

    /**
     * Status title
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Detailed event description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Remark regarding the shipment status
     *
     * @return string
     */
    public function getRemark(): string;

    /**
     * Description of the next steps for the shipment
     *
     * @return string
     */
    public function getNextSteps(): string;
}
