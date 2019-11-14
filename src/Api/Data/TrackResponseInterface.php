<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface TrackResponseInterface
 *
 * Describing a tracking response from the unified tracking API with a flat structure
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface TrackResponseInterface
{
    /**
     * The tracking id
     *
     * @return string
     */
    public function getTrackingId(): string;

    /**
     * In case the response contains multiple entries for one tracking id the sequence number can be used to uniquely
     * identify the response item
     *
     * @return int
     */
    public function getSequenceNumber(): int;

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
