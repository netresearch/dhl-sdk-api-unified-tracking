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
 */
interface TrackResponseInterface
{
    public function getTrackingId(): string;

    /**
     * In case the response contains multiple entries for one tracking id the sequence number can be used to uniquely
     * identify the response item
     */
    public function getSequenceNumber(): int;

    /**
     * The responsible DHL carrier service
     */
    public function getService(): string;

    public function getEstimatedDeliveryTime(): ?EstimatedDeliveryInterface;

    public function getOriginAddress(): ?AddressInterface;

    public function getDestinationAddress(): ?AddressInterface;

    /**
     * Last relevant shipment event registered for this shipment
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
     */
    public function getSender(): ?PersonInterface;

    /**
     * Personal information of the receiver
     */
    public function getReceiver(): ?PersonInterface;

    /**
     * Product name of the shipping product used to transport the shipment
     */
    public function getShippingProduct(): ?string;

    /**
     * Number of packages associated with this shipment
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
     */
    public function getProofOfDelivery(): ?ProofOfDeliveryInterface;

    /**
     * Accessor for attributes such as weight or package dimensions
     */
    public function getPhysicalAttributes(): ?PhysicalAttributesInterface;

    /**
     * List of reference numbers to the shipment
     *
     * @return ShipmentReferenceInterface[]
     */
    public function getShipmentReferences(): array;
}
