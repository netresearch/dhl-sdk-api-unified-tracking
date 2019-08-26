<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

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
     * @var Organization
     */
    private $carrier;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Person
     */
    private $receiver;

    /**
     * @var Person
     */
    private $sender;

    /**
     * @var ProofOfDelivery
     */
    private $proofOfDelivery;

    /**
     * Total number of items or pieces in the shipment
     *
     * @var int
     */
    private $totalNumberOfPiece;

    /**
     * Ids of all the items or pieces in the shipment
     *
     * @var string[]
     */
    private $pieceIds;

    /**
     * @var Unit
     */
    private $weight;

    /**
     * @var Unit
     */
    private $volume;

    /**
     * A loading meter standard unit of measurement for transport by truck
     *
     * @var float
     */
    private $loadingMeters;

    /**
     * @var Dimension
     */
    private $dimensions;

    /**
     * @var Reference
     */
    private $references;

    /**
     * @FIXME(nr) this property has a colon in its name according to spec - dunno how that should work - PSI
     * @var array
     */
    private $dgf_routes;

    /**
     * @return Organization
     */
    public function getCarrier(): Organization
    {
        return $this->carrier;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return Person
     */
    public function getReceiver(): Person
    {
        return $this->receiver;
    }

    /**
     * @return Person
     */
    public function getSender(): Person
    {
        return $this->sender;
    }

    /**
     * @return ProofOfDelivery
     */
    public function getProofOfDelivery(): ProofOfDelivery
    {
        return $this->proofOfDelivery;
    }

    /**
     * @return int
     */
    public function getTotalNumberOfPiece(): int
    {
        return $this->totalNumberOfPiece;
    }

    /**
     * @return string[]
     */
    public function getPieceIds(): array
    {
        return $this->pieceIds;
    }

    /**
     * @return Unit
     */
    public function getWeight(): Unit
    {
        return $this->weight;
    }

    /**
     * @return Unit
     */
    public function getVolume(): Unit
    {
        return $this->volume;
    }

    /**
     * @return float
     */
    public function getLoadingMeters(): float
    {
        return $this->loadingMeters;
    }

    /**
     * @return Dimension
     */
    public function getDimensions(): Dimension
    {
        return $this->dimensions;
    }

    /**
     * @return Reference
     */
    public function getReferences(): Reference
    {
        return $this->references;
    }

    /**
     * @return array
     */
    public function getDgfRoutes(): array
    {
        return $this->dgf_routes;
    }
}
