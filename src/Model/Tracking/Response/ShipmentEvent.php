<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Response;

use Dhl\Sdk\Group\Tracking\Api\Data\AddressInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\ShipmentEventInterface;

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

    /**
     * ShipmentEvent constructor.
     *
     * @param \DateTime $timeStamp
     * @param string $statusCode
     * @param string $status
     * @param string $description
     * @param string $remark
     * @param string $nextSteps
     * @param AddressInterface|null $location
     */
    public function __construct(
        \DateTime $timeStamp,
        string $statusCode = '',
        string $status = '',
        string $description = '',
        string $remark = '',
        string $nextSteps = '',
        AddressInterface $location = null
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

    public function getLocation()
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
