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
    /**
     * @var Organization|null
     */
    private $carrier;

    /**
     * @var Product|null
     */
    private $product;

    /**
     * @var Person|null
     */
    private $receiver;

    /**
     * @var Person|null
     */
    private $sender;

    /**
     * @var ProofOfDelivery|null
     */
    private $proofOfDelivery;

    /**
     * Total number of items or pieces in the shipment
     *
     * @var int|null
     */
    private $totalNumberOfPieces;

    /**
     * Ids of all the items or pieces in the shipment
     *
     * @var string[]
     */
    private $pieceIds = [];

    /**
     * @var Unit
     */
    private $weight;

    /**
     * @var Unit|null
     */
    private $volume;

    /**
     * A loading meter standard unit of measurement for transport by truck
     *
     * @var float|null
     */
    private $loadingMeters;

    /**
     * @var Dimension|null
     */
    private $dimensions;

    /**
     * @var Reference[]
     */
    private $references = [];

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
