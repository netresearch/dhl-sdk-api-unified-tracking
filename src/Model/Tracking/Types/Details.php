<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking\Types;

/**
 * Class Details
 *
 * Detailed information about one shipment
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
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

    /**
     * @return Organization|null
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return Person|null
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @return Person|null
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return ProofOfDelivery|null
     */
    public function getProofOfDelivery()
    {
        return $this->proofOfDelivery;
    }

    /**
     * @return int|null
     */
    public function getTotalNumberOfPieces()
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

    /**
     * @return Unit|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return Unit|null
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return float|null
     */
    public function getLoadingMeters()
    {
        return $this->loadingMeters;
    }

    /**
     * @return Dimension|null
     */
    public function getDimensions()
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
