<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Shipment
 *
 * One shipment information including full shipment details and complete list of shipment events.
 */
class Shipment
{
    /**
     * Tracking number
     */
    private string $id;

    /**
     * Service (provider) used to resolve this tracking number (id).
     * Possible values:
     * - freight
     * - express
     * - parcel-de
     * - parcel-nl
     * - parcel-pl
     * - dsc
     * - dgf
     * - ecommerce
     *
     * @var string
     */
    private string $service;

    /**
     * Shipment origin
     */
    private ?Place $origin = null;

    /**
     * Shipment destination
     */
    private ?Place $destination = null;

    private ShipmentEvent $status;

    /**
     * Timestamp, e.g 2018-08-03T00:00:00Z
     */
    private string $estimatedTimeOfDelivery = '';

    private ?EstimatedTimeFrame $estimatedDeliveryTimeFrame = null;

    private string $estimatedTimeOfDeliveryRemark = '';

    private ?Details $details = null;

    /**
     * @var ShipmentEvent[]
     */
    private array $events = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getOrigin(): ?Place
    {
        return $this->origin;
    }

    public function getDestination(): ?Place
    {
        return $this->destination;
    }

    public function getStatus(): ShipmentEvent
    {
        return $this->status;
    }

    public function getEstimatedTimeOfDelivery(): string
    {
        return $this->estimatedTimeOfDelivery;
    }

    public function getEstimatedDeliveryTimeFrame(): ?EstimatedTimeFrame
    {
        return $this->estimatedDeliveryTimeFrame;
    }

    public function getEstimatedTimeOfDeliveryRemark(): string
    {
        return $this->estimatedTimeOfDeliveryRemark;
    }

    public function getDetails(): ?Details
    {
        return $this->details;
    }

    /**
     * @return ShipmentEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
