<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking;

use Dhl\Sdk\UnifiedTracking\Api\Data\AddressInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\EstimatedDeliveryInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\PersonInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\PhysicalAttributesInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ProofOfDeliveryInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentEventInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentReferenceInterface;
use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;

class TrackResponse implements TrackResponseInterface
{
    /**
     * TrackResponse constructor.
     *
     * @param ShipmentEventInterface[] $statusEvents
     * @param string[] $relatedPieceIds
     * @param ShipmentReferenceInterface[] $shipmentReferences
     */
    public function __construct(
        private readonly string $trackingId,
        private readonly int $sequenceNumber,
        private readonly string $service,
        private readonly ShipmentEventInterface $latestStatus,
        private readonly int $numberOfPieces,
        private readonly ?PhysicalAttributesInterface $physicalAttributes,
        private readonly ?AddressInterface $destinationAddress,
        private readonly ?AddressInterface $originAddress,
        private readonly string $shippingProduct,
        private readonly ?EstimatedDeliveryInterface $estimatedDeliveryTime,
        private readonly ?PersonInterface $sender,
        private readonly ?PersonInterface $receiver,
        private readonly ?ProofOfDeliveryInterface $proofOfDelivery,
        private readonly array $statusEvents = [],
        private readonly array $relatedPieceIds = [],
        private readonly array $shipmentReferences = []
    ) {
    }

    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getEstimatedDeliveryTime(): ?EstimatedDeliveryInterface
    {
        return $this->estimatedDeliveryTime;
    }

    public function getOriginAddress(): ?AddressInterface
    {
        return $this->originAddress;
    }

    public function getDestinationAddress(): ?AddressInterface
    {
        return $this->destinationAddress;
    }

    public function getLatestStatus(): ShipmentEventInterface
    {
        return $this->latestStatus;
    }

    /**
     * @return ShipmentEventInterface[]
     */
    public function getStatusEvents(): array
    {
        return $this->statusEvents;
    }

    public function getSender(): ?PersonInterface
    {
        return $this->sender;
    }

    public function getReceiver(): ?PersonInterface
    {
        return $this->receiver;
    }

    public function getShippingProduct(): string
    {
        return $this->shippingProduct;
    }

    public function getNumberOfPieces(): int
    {
        return $this->numberOfPieces;
    }

    /**
     * @return string[]
     */
    public function getRelatedPieceIds(): array
    {
        return $this->relatedPieceIds;
    }

    public function getProofOfDelivery(): ?ProofOfDeliveryInterface
    {
        return $this->proofOfDelivery;
    }

    public function getPhysicalAttributes(): ?PhysicalAttributesInterface
    {
        return $this->physicalAttributes;
    }

    /**
     * @return ShipmentReferenceInterface[]
     */
    public function getShipmentReferences(): array
    {
        return $this->shipmentReferences;
    }
}
