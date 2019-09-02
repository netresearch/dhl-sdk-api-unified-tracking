<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking;

use Dhl\Sdk\Group\Tracking\Api\Data\AddressInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\EstimatedDeliveryInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\PersonInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\PhysicalAttributesInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\ProofOfDeliveryInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\ShipmentEventInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\ShipmentReferenceInterface;
use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;

class TrackResponse implements TrackResponseInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $service;

    /**
     * @var EstimatedDeliveryInterface|null
     */
    private $estimatedDeliveryTime;

    /**
     * @var AddressInterface
     */
    private $originAddress;

    /**
     * @var AddressInterface
     */
    private $destinationAddress;

    /**
     * @var ShipmentEventInterface
     */
    private $latestStatus;

    /**
     * @var ShipmentEventInterface[]
     */
    private $statusEvents = [];

    /**
     * @var PersonInterface|null
     */
    private $sender;

    /**
     * @var PersonInterface|null
     */
    private $receiver;

    /**
     * @var string
     */
    private $shippingProduct = '';

    /**
     * @var int
     */
    private $numberOfPieces = 1;

    /**
     * @var string[]
     */
    private $relatedPieceIds = [];

    /**
     * @var ProofOfDeliveryInterface|null
     */
    private $proofOfDelivery;

    /**
     * @var PhysicalAttributesInterface
     */
    private $physicalAttributes;

    /**
     * @var ShipmentReferenceInterface[]
     */
    private $shipmentReferences = [];

    /**
     * TrackResponse constructor.
     *
     * @param string $trackingId
     * @param string $service
     * @param AddressInterface $originAddress
     * @param AddressInterface $destinationAddress
     * @param ShipmentEventInterface $latestStatus
     * @param int $numberOfPieces
     * @param PhysicalAttributesInterface $physicalAttributes
     * @param string $shippingProduct
     * @param EstimatedDeliveryInterface|null $estimatedDeliveryTime
     * @param PersonInterface|null $sender
     * @param PersonInterface|null $receiver
     * @param ProofOfDeliveryInterface|null $proofOfDelivery
     * @param array $statusEvents
     * @param array $relatedPieceIds
     * @param array $shipmentReferences
     */
    public function __construct(
        string $trackingId,
        string $service,
        AddressInterface $originAddress,
        AddressInterface $destinationAddress,
        ShipmentEventInterface $latestStatus,
        int $numberOfPieces,
        PhysicalAttributesInterface $physicalAttributes,
        string $shippingProduct = '',
        EstimatedDeliveryInterface $estimatedDeliveryTime = null,
        PersonInterface $sender = null,
        PersonInterface $receiver = null,
        ProofOfDeliveryInterface $proofOfDelivery = null,
        array $statusEvents = [],
        array $relatedPieceIds = [],
        array $shipmentReferences = []
    ) {
        $this->id = $trackingId;
        $this->service = $service;
        $this->estimatedDeliveryTime = $estimatedDeliveryTime;
        $this->originAddress = $originAddress;
        $this->destinationAddress = $destinationAddress;
        $this->latestStatus = $latestStatus;
        $this->statusEvents = $statusEvents;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->shippingProduct = $shippingProduct;
        $this->numberOfPieces = $numberOfPieces;
        $this->relatedPieceIds = $relatedPieceIds;
        $this->proofOfDelivery = $proofOfDelivery;
        $this->physicalAttributes = $physicalAttributes;
        $this->shipmentReferences = $shipmentReferences;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getEstimatedDeliveryTime()
    {
        return $this->estimatedDeliveryTime;
    }

    public function getOriginAddress()
    {
        return $this->originAddress;
    }

    public function getDestinationAddress()
    {
        return $this->destinationAddress;
    }

    public function getLatestStatus(): ShipmentEventInterface
    {
        return $this->latestStatus;
    }

    public function getStatusEvents(): array
    {
        return $this->statusEvents;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getShippingProduct()
    {
        return $this->shippingProduct;
    }

    public function getNumberOfPieces(): int
    {
        return $this->numberOfPieces;
    }

    public function getRelatedPieceIds(): array
    {
        return $this->relatedPieceIds;
    }

    public function getProofOfDelivery()
    {
        return $this->proofOfDelivery;
    }

    public function getPhysicalAttributes(): PhysicalAttributesInterface
    {
        return $this->physicalAttributes;
    }

    public function getShipmentReferences(): array
    {
        return $this->shipmentReferences;
    }
}
