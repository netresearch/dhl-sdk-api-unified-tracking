<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model;

use Dhl\Sdk\GroupTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\Address;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\DeliveryTimeFrame;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\EstimatedDelivery;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\Person;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\PhysicalAttributes;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\ProofOfDelivery;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\ShipmentEvent;
use Dhl\Sdk\GroupTracking\Model\Tracking\Response\ShipmentReference;
use Dhl\Sdk\GroupTracking\Model\Tracking\TrackResponse;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Details;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Person as ApiPerson;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Place;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Reference;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Shipment;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\ShipmentEvent as ApiShipmentEvent;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\TrackingResponseType;

class ResponseMapper
{
    /**
     * @param TrackingResponseType $response
     * @return TrackResponseInterface[]
     * @throws \Exception
     */
    public function map(TrackingResponseType $response): array
    {
        $results = [];
        /** @var Shipment $shipment */
        foreach ($response->getShipments() as $shipment) {
            $shipmentDetails = $shipment->getDetails();
            $proofOfDelivery = $shipmentDetails->getProofOfDelivery() !== null ? $this->convertProofOfDelivery(
                $shipmentDetails->getProofOfDelivery()
            ) : null;

            $shipmentEvents = array_map([$this, 'convertEvent'], $shipment->getEvents());
            $shipmentReferences = array_map(
                function (Reference $reference) {
                    return new ShipmentReference(
                        $reference->getType(),
                        $reference->getNumber()
                    );
                },
                $shipmentDetails->getReferences()
            );
            $physicalAttributes = null;
            if ($shipment->getDetails()->getWeight() !== null || $shipment->getDetails()->getDimensions() !== null) {
                $physicalAttributes = $this->createPhysicalAttributes($shipmentDetails);
            }
            $trackingId = $shipment->getId();
            $results[$trackingId] = new TrackResponse(
                $trackingId,
                $shipment->getService(),
                $this->convertEvent($shipment->getStatus()),
                $shipmentDetails->getTotalNumberOfPieces(),
                $physicalAttributes,
                $shipment->getDestination() !== null ? $this->convertAddress($shipment->getDestination()) : null,
                $shipment->getOrigin() !== null ? $this->convertAddress($shipment->getOrigin()) : null,
                $shipmentDetails->getProduct() !== null ? $shipmentDetails->getProduct()->getProductName() : '',
                !empty($shipment->getEstimatedTimeOfDelivery()) ? $this->extractEstimatedDelivery($shipment) : null,
                $shipmentDetails->getSender() !== null ? $this->convertPerson($shipmentDetails->getSender()) : null,
                $shipmentDetails->getReceiver() !== null ? $this->convertPerson($shipmentDetails->getReceiver()) : null,
                $proofOfDelivery,
                $shipmentEvents,
                $shipmentDetails->getPieceIds(),
                $shipmentReferences
            );
        }

        return $results;
    }

    /**
     * @param Tracking\Types\ProofOfDelivery $proofOfDelivery
     * @return ProofOfDelivery
     * @throws \Exception
     */
    private function convertProofOfDelivery(
        Tracking\Types\ProofOfDelivery $proofOfDelivery
    ): ProofOfDelivery {
        return new ProofOfDelivery(
            new \DateTime($proofOfDelivery->getTimestamp()),
            $proofOfDelivery->getDocumentUrl(),
            $proofOfDelivery->getSigned() !== null ? $this->convertPerson($proofOfDelivery->getSigned()) : null
        );
    }

    private function convertPerson(
        ApiPerson $person
    ): Person {
        return new Person(
            $person->getOrganizationName(),
            $person->getFamilyName(),
            $person->getGivenName(),
            $person->getName()
        );
    }

    /**
     * @param Details $details
     * @return PhysicalAttributes
     */
    private function createPhysicalAttributes(
        Details $details
    ): PhysicalAttributes {
        $dimensionUnit = '';
        $width = null;
        $height = null;
        $length = null;
        $weight = null;
        $weightUom = '';
        if ($details->getDimensions() !== null) {
            $dimensionUnit = $details->getDimensions()->getHeight()->getUnitText();
            $width = $details->getDimensions()->getWidth()->getValue();
            $height = $details->getDimensions()->getHeight()->getValue();
            $length = $details->getDimensions()->getLength()->getValue();
        }

        if ($details->getWeight() !== null) {
            $weight = $details->getWeight()->getValue();
            $weightUom = $details->getWeight()->getUnitText();
        }

        return new PhysicalAttributes(
            $weight,
            $weightUom,
            $dimensionUnit,
            $width,
            $height,
            $length,
            $details->getLoadingMeters()
        );
    }

    /**
     * @param ApiShipmentEvent $event
     * @return ShipmentEvent
     * @throws \Exception
     */
    private function convertEvent(
        ApiShipmentEvent $event
    ): ShipmentEvent {
        $location = $event->getLocation() !== null ? $this->convertAddress($event->getLocation()) : null;

        return new ShipmentEvent(
            new \DateTime($event->getTimestamp()),
            $event->getStatusCode(),
            $event->getStatus(),
            $event->getDescription(),
            $event->getRemark(),
            $event->getNextSteps(),
            $location
        );
    }

    /**
     * @param Place $place
     * @return Address
     */
    private function convertAddress(
        Place $place
    ): Address {
        return new Address(
            $place->getAddress()->getCountryCode(),
            $place->getAddress()->getPostalCode(),
            $place->getAddress()->getAddressLocality(),
            $place->getAddress()->getStreetAddress()
        );
    }

    private function extractEstimatedDelivery(
        Shipment $shipment
    ): EstimatedDelivery {
        $timeFrame = $shipment->getEstimatedDeliveryTimeFrame() !== null ? new DeliveryTimeFrame(
            new \DateTime($shipment->getEstimatedDeliveryTimeFrame()->getEstimatedFrom()),
            new \DateTime($shipment->getEstimatedDeliveryTimeFrame()->getEstimatedThrough())
        ) : null;

        return new EstimatedDelivery(
            new \DateTime($shipment->getEstimatedTimeOfDelivery()),
            $timeFrame,
            $shipment->getEstimatedTimeOfDeliveryRemark()
        );
    }
}
