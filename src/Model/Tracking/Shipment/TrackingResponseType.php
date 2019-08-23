<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;


class TrackingResponseType
{
    /**
     * List of shipments matching the input query.
     *
     * @var Shipment[]
     */
    public $shipments;

    /**
     * Array of URLs to potentially additional matching shipments in the other services.
     *
     * @var string[]
     */
    public $possibleAdditionalShipmentsUrl;
}
