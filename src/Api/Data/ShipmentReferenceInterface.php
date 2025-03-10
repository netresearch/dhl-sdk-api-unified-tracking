<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface ShipmentReferenceInterface
 *
 * Describing shipment references given by the API
 *
 * @api
 */
interface ShipmentReferenceInterface
{
    /**
     * Reference type, one of:
     * - customer-reference
     * - customer-confirmation-number
     * - local-tracking-number
     * - ecommerce-number
     * - housebill
     * - masterbill
     * - container-number
     * - domestic-consignment-id
     */
    public function getType(): string;

    /**
     * Reference number
     */
    public function getNumber(): string;
}
