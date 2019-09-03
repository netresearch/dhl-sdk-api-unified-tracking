<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Api\Data;

/**
 * Interface TrackResponseInterface
 *
 * Describing a tracking response from the group tracking API with a flat structure
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link http://www.netresearch.de/
 */
interface TrackResponseInterface
{
    /**
     * The tracking id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * The responsible DHL carrier service
     *
     * @return string
     */
    public function getService(): string;

    /**
     * Delivery date/time estimation
     *
     * @return EstimatedDeliveryInterface|null
     */
    public function getEstimatedDeliveryTime();

    /**
     * Shipping origin address
     *
     * @return AddressInterface|null
     */
    public function getOriginAddress();

    /**
     * Shipping destination address
     *
     * @return AddressInterface|null
     */
    public function getDestinationAddress();

    /**
     * Last relevant shipment event registered for this shipment
     *
     * @return ShipmentEventInterface
     */
    public function getLatestStatus(): ShipmentEventInterface;

    /**
     * List of handling events for this shipment
     *
     * @return ShipmentEventInterface[]
     */
    public function getStatusEvents(): array;

    /**
     * Personal information of the shipper
     *
     * @return PersonInterface|null
     */
    public function getSender();
    // sender

    /**
     * Personal information of the receiver
     *
     * @return PersonInterface|null
     */
    public function getReceiver();

    /**
     * Product name of the shipping product used to transport the shipment
     *
     * @return string|null
     */
    public function getShippingProduct();

    /**
     * Number of packages associated with this shipment
     *
     * @return int
     */
    public function getNumberOfPieces(): int;

    /**
     * List of tracking ids for packages related to this shipment
     *
     * @return string[]
     */
    public function getRelatedPieceIds(): array;

    /**
     * Documents related to the proof of delivery
     *
     * @return ProofOfDeliveryInterface|null
     */
    public function getProofOfDelivery();

    /**
     * Accessor for attributes such as weight or package dimensions
     *
     * @return PhysicalAttributesInterface|null
     */
    public function getPhysicalAttributes();

    /**
     * List of reference numbers to the shipment
     *
     * @return ShipmentReferenceInterface[]
     */
    public function getShipmentReferences(): array;
}
