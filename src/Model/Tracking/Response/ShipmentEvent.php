<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\AddressInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentEventInterface;

class ShipmentEvent implements ShipmentEventInterface
{
    /**
     * @var \DateTime
     */
    private $timeStamp;

    /**
     * @var AddressInterface|null
     */
    private $location;

    /**
     * @var string
     */
    private $statusCode;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $nextSteps;

    public function __construct(
        \DateTime $timeStamp,
        string $statusCode = '',
        string $status = '',
        string $description = '',
        string $remark = '',
        string $nextSteps = '',
        ?AddressInterface $location = null
    ) {
        $this->timeStamp = $timeStamp;
        $this->location = $location;
        $this->statusCode = $statusCode;
        $this->status = $status;
        $this->description = $description;
        $this->remark = $remark;
        $this->nextSteps = $nextSteps;
    }

    public function getTimeStamp(): \DateTime
    {
        return $this->timeStamp;
    }

    public function getLocation(): ?AddressInterface
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
