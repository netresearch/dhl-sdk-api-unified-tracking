<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Api\Data;

/**
 * Interface ShipmentReferenceInterface
 *
 * Describing shipment references given by the API
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
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
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Reference number
     *
     * @return string
     */
    public function getNumber(): string;
}
