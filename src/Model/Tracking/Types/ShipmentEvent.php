<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class ShipmentEvent
 *
 * An event in shipment delivery; also known as Milestone, Checkpoint, Status History Entry
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

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getLocation(): ?Place
    {
        return $this->location;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRemark(): string
    {
        return $this->remark;
    }

    public function getNextSteps(): string
    {
        return $this->nextSteps;
    }
}
