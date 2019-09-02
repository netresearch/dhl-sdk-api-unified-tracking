<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

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
     * @var Place
     */
    private $origin;

    /**
     * Shipment destination
     *
     * @var Place
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
     * @var Details
     */
    private $details;

    /**
     * @var ShipmentEvent[]
     */
    private $events = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return Place
     */
    public function getOrigin(): Place
    {
        return $this->origin;
    }

    /**
     * @return Place
     */
    public function getDestination(): Place
    {
        return $this->destination;
    }

    /**
     * @return ShipmentEvent
     */
    public function getStatus(): ShipmentEvent
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getEstimatedTimeOfDelivery(): string
    {
        return $this->estimatedTimeOfDelivery;
    }

    /**
     * @return EstimatedTimeFrame|null
     */
    public function getEstimatedDeliveryTimeFrame()
    {
        return $this->estimatedDeliveryTimeFrame;
    }

    /**
     * @return string
     */
    public function getEstimatedTimeOfDeliveryRemark(): string
    {
        return $this->estimatedTimeOfDeliveryRemark;
    }

    /**
     * @return Details
     */
    public function getDetails(): Details
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
