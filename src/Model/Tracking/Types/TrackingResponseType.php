<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class TrackingResponseType
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class TrackingResponseType
{
    /**
     * List of shipments matching the input query.
     *
     * @var Shipment[]
     */
    private $shipments = [];

    /**
     * Array of URLs to potentially additional matching shipments in the other services.
     *
     * @var string[]
     */
    private $possibleAdditionalShipmentsUrl = [];

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
