<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

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
    private $timestamp = '';

    /**
     * @var Place|null
     */
    private $location;

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
    private $statusCode = '';

    /**
     * Short description of the status - title
     *
     * @var string
     */
    private $status = '';

    /**
     * Detailed description of the event
     *
     * @var string
     */
    private $description = '';

    /**
     * Remark regarding the shipment status
     *
     * @var string
     */
    private $remark = '';

    /**
     * Description of the next steps
     *
     * @var string
     */
    private $nextSteps = '';

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @return Place|null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @return string
     */
    public function getNextSteps(): string
    {
        return $this->nextSteps;
    }
}
