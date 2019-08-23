<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

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
    public $carrier;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Person
     */
    public $receiver;

    /**
     * @var Person
     */
    public $sender;

    /**
     * @var ProofOfDelivery
     */
    public $proofOfDelivery;

    /**
     * Total number of items or pieces in the shipment
     *
     * @var int
     */
    public $totalNumberOfPiece;

    /**
     * Ids of all the items or pieces in the shipment
     *
     * @var string[]
     */
    public $pieceIds;

    /**
     * @var Unit
     */
    public $weight;

    /**
     * @var Unit
     */
    public $volume;

    /**
     * A loading meter standard unit of measurement for transport by truck
     *
     * @var float
     */
    public $loadingMeters;

    /**
     * @var Dimension
     */
    public $dimensions;

    /**
     * @var Reference
     */
    public $references;

    /**
     * @var array
     */
    public $dgf_routes;
}
