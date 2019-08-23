<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

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
    public $id;

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
    public $service;

    /**
     * Shipment origin
     *
     * @var Place
     */
    public $origin;

    /**
     * Shipment destination
     *
     * @var Place
     */
    public $destination;

    /**
     * @var ShipmentEvent
     */
    public $status;

    /**
     * Timestamp, e.g 2018-08-03T00:00:00Z
     *
     * @var string
     */
    public $estimatedTimeOfDelivery;

    /**
     * @var EstimatedTimeFrame
     */
    public $estimatedDeliveryTimeFrame;

    /**
     * @var string
     */
    public $estimatedTimeOfDeliveryRemark;

    /**
     * @var Details
     */
    public $details;

    /**
     * @var ShipmentEvent[]
     */
    public $events;
}
