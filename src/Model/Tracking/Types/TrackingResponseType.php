<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class TrackingResponseType
{
    /**
     * List of shipments matching the input query.
     *
     * @var Shipment[]
     */
    private array $shipments = [];

    /**
     * Array of URLs to potentially additional matching shipments in the other services.
     *
     * @var string[]
     */
    private array $possibleAdditionalShipmentsUrl = [];

    /**
     * @return Shipment[]
     */
    public function getShipments(): array
    {
        return $this->shipments;
    }

    /**
     * @return string[]
     */
    public function getPossibleAdditionalShipmentsUrl(): array
    {
        return $this->possibleAdditionalShipmentsUrl;
    }
}
