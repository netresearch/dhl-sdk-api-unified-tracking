<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

/**
 * Class ShipmentEvent
 *
 * An event in shipment delivery; also known as Milestone, Checkpoint, Status History Entry
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ShipmentEvent
{
    /**
     * A date value in ISO 8601 format (2017-06-21) or a combination of date and time of day (2017-06-21T14:07:17Z)
     *
     * @var string
     */
    public $timestamp;

    /**
     * @var Place
     */
    public $location;

    /**
     * Code of the event; These codes are high-level grouping statuses.
     * - pre-transit
     * - transit
     * - delivered
     * - failure
     * - unknown
     *
     * @var string
     */
    public $statusCode;

    /**
     * Short description of the status - title
     *
     * @var string
     */
    public $status;

    /**
     * Detailed description of the event
     *
     * @var string
     */
    public $description;

    /**
     * Remark regarding the shipment status
     *
     * @var string
     */
    public $remark;

    /**
     * Description of the next steps
     *
     * @var string
     */
    public $nextSteps;
}
