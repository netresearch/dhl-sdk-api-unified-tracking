<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking;

use Dhl\Sdk\GroupTracking\Api\Data\AddressInterface;
use Dhl\Sdk\GroupTracking\Api\Data\EstimatedDeliveryInterface;
use Dhl\Sdk\GroupTracking\Api\Data\PersonInterface;
use Dhl\Sdk\GroupTracking\Api\Data\PhysicalAttributesInterface;
use Dhl\Sdk\GroupTracking\Api\Data\ProofOfDeliveryInterface;
use Dhl\Sdk\GroupTracking\Api\Data\ShipmentEventInterface;
use Dhl\Sdk\GroupTracking\Api\Data\ShipmentReferenceInterface;
use Dhl\Sdk\GroupTracking\Api\Data\TrackResponseInterface;

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
     * @var AddressInterface|null
     */
    private $originAddress;

    /**
     * @var AddressInterface|null
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
     * @var PhysicalAttributesInterface|null
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
     * @param ShipmentEventInterface $latestStatus
     * @param int $numberOfPieces
     * @param PhysicalAttributesInterface|null $physicalAttributes
     * @param AddressInterface|null $destinationAddress
     * @param AddressInterface|null $originAddress
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
        ShipmentEventInterface $latestStatus,
        int $numberOfPieces = 1,
        PhysicalAttributesInterface $physicalAttributes = null,
        AddressInterface $destinationAddress = null,
        AddressInterface $originAddress = null,
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

    public function getPhysicalAttributes()
    {
        return $this->physicalAttributes;
    }

    public function getShipmentReferences(): array
    {
        return $this->shipmentReferences;
    }
}
