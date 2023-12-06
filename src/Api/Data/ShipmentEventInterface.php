<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface ShipmentEventInterface
 *
 * Describing events in shipment handling
 *
 * @api
 */
interface ShipmentEventInterface
{
    final public const STATUS_CODE_PRE_TRANSIT = 'pre-transit';
    final public const STATUS_CODE_TRANSIT = 'transit';
    final public const STATUS_CODE_DELIVERED = 'delivered';
    final public const STATUS_CODE_FAILURE = 'failure';
    final public const STATUS_CODE_UNKNOWN = 'unknown';

    /**
     * Time on which the event happened
     */
    public function getTimeStamp(): \DateTime;

    /**
     * Location information to the event
     */
    public function getLocation(): ?AddressInterface;

    /**
     * High level status group, one of:
     * - pre-transit
     * - transit
     * - delivered
     * - failure
     * - unknown
     */
    public function getStatusCode(): string;

    /**
     * Status title
     */
    public function getStatus(): string;

    /**
     * Detailed event description
     */
    public function getDescription(): string;

    /**
     * Remark regarding the shipment status
     */
    public function getRemark(): string;

    /**
     * Description of the next steps for the shipment
     */
    public function getNextSteps(): string;
}
