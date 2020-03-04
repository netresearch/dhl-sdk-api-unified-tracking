<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Shipment
 * One shipment information including full shipment details and complete list of shipment events.
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Shipment
{
    /**
     * Tracking number
     *
     * @var string
     */
    private $id;

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
    private $service;

    /**
     * Shipment origin
     *
     * @var Place|null
     */
    private $origin;

    /**
     * Shipment destination
     *
     * @var Place|null
     */
    private $destination;

    /**
     * @var ShipmentEvent
     */
    private $status;

    /**
     * Timestamp, e.g 2018-08-03T00:00:00Z
     *
     * @var string
     */
    private $estimatedTimeOfDelivery = '';

    /**
     * @var EstimatedTimeFrame
     */
    private $estimatedDeliveryTimeFrame;

    /**
     * @var string
     */
    private $estimatedTimeOfDeliveryRemark = '';

    /**
     * @var Details|null
     */
    private $details;

    /**
     * @var ShipmentEvent[]
     */
    private $events = [];

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
