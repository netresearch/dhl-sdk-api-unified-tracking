<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Details
 *
 * Detailed information about one shipment
 */
class Details
{
    private ?Organization $carrier = null;

    private ?Product $product = null;

    private ?Person $receiver = null;

    private ?Person $sender = null;

    private ?ProofOfDelivery $proofOfDelivery = null;

    /**
     * Total number of items or pieces in the shipment
     */
    private ?int $totalNumberOfPieces = null;

    /**
     * Ids of all the items or pieces in the shipment
     *
     * @var string[]
     */
    private array $pieceIds = [];

    private ?Unit $weight = null;

    private ?Unit $volume = null;

    /**
     * A loading meter standard unit of measurement for transport by truck
     */
    private ?float $loadingMeters = null;

    private ?Dimension $dimensions = null;

    /**
     * @var Reference[]
     */
    private array $references = [];

    public function getCarrier(): ?Organization
    {
        return $this->carrier;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getReceiver(): ?Person
    {
        return $this->receiver;
    }

    public function getSender(): ?Person
    {
        return $this->sender;
    }

    public function getProofOfDelivery(): ?ProofOfDelivery
    {
        return $this->proofOfDelivery;
    }

    public function getTotalNumberOfPieces(): ?int
    {
        return $this->totalNumberOfPieces;
    }

    /**
     * @return string[]
     */
    public function getPieceIds(): array
    {
        return $this->pieceIds;
    }

    public function getWeight(): ?Unit
    {
        return $this->weight;
    }

    public function getVolume(): ?Unit
    {
        return $this->volume;
    }

    public function getLoadingMeters(): ?float
    {
        return $this->loadingMeters;
    }

    public function getDimensions(): ?Dimension
    {
        return $this->dimensions;
    }

    /**
     * @return Reference[]
     */
    public function getReferences(): array
    {
        return $this->references;
    }
}
