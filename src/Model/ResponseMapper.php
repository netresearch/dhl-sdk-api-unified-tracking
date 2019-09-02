<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\Address;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\DeliveryTimeFrame;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\EstimatedDelivery;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\Person;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\PhysicalAttributes;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\ProofOfDelivery;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\ShipmentEvent;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Response\ShipmentReference;
use Dhl\Sdk\Group\Tracking\Model\Tracking\TrackResponse;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\Details;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\Person as ApiPerson;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\Place;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\Reference;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\Shipment;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\ShipmentEvent as ApiShipmentEvent;
use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\TrackingResponseType;

class ResponseMapper
{
    public function map(TrackingResponseType $response): TrackResponseInterface
    {
        /** @var Shipment $shipment */
        $shipment = current($response->getShipments());

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

        return new TrackResponse(
            $shipment->getId(),
            $shipment->getService(),
            $this->convertAddress($shipment->getOrigin()),
            $this->convertAddress($shipment->getDestination()),
            $this->convertEvent($shipment->getStatus()),
            $shipmentDetails->getTotalNumberOfPieces(),
            $this->createPhysicalAttributes($shipmentDetails),
            $shipmentDetails->getProduct() !== null ? $shipmentDetails->getProduct()->getProductName() : '',
            empty($shipment->getEstimatedTimeOfDelivery()) ? $this->extractEstimatedDelivery($shipment) : null,
            $shipmentDetails->getSender() !== null ? $this->convertPerson($shipmentDetails->getSender()) : null,
            $shipmentDetails->getReceiver() !== null ? $this->convertPerson($shipmentDetails->getReceiver()) : null,
            $proofOfDelivery,
            $shipmentEvents,
            $shipmentDetails->getPieceIds(),
            $shipmentReferences
        );
    }

    /**
     * @param Tracking\Types\ProofOfDelivery $proofOfDelivery
     * @return ProofOfDelivery
     * @throws \Exception
     */
    private function convertProofOfDelivery(Tracking\Types\ProofOfDelivery $proofOfDelivery): ProofOfDelivery
    {
        return new ProofOfDelivery(
            new \DateTime($proofOfDelivery->getTimestamp()),
            $proofOfDelivery->getDocumentUrl(),
            $proofOfDelivery->getSigned() !== null ? $this->convertPerson($proofOfDelivery->getSigned()) : null
        );
    }

    private function convertPerson(ApiPerson $person): Person
    {
        return new Person(
            $person->getOrganizationName(),
            $person->getFamilyName(),
            $person->getGivenName(),
            $person->getName()
        );
    }

    /**
     * @param Place $place
     * @return Address
     */
    private function convertAddress(Place $place): Address
    {
        return new Address(
            $place->getAddress()->getCountryCode(),
            $place->getAddress()->getPostalCode(),
            $place->getAddress()->getAddressLocality(),
            $place->getAddress()->getStreetAddress()
        );
    }

    /**
     * @param ApiShipmentEvent $event
     * @return ShipmentEvent
     * @throws \Exception
     */
    private function convertEvent(ApiShipmentEvent $event): ShipmentEvent
    {
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
     * @param Details $details
     * @return PhysicalAttributes
     */
    private function createPhysicalAttributes(Details $details): PhysicalAttributes
    {
        if ($details->getDimensions() === null) {
            $dimensionUnit = '';
            $width = null;
            $height = null;
            $length = null;
        } else {
            $dimensionUnit = $details->getDimensions()->getHeight()->getUnitText();
            $width = $details->getDimensions()->getWidth()->getValue();
            $height = $details->getDimensions()->getHeight()->getValue();
            $length = $details->getDimensions()->getLength()->getValue();
        }

        return new PhysicalAttributes(
            $details->getWeight()->getValue(),
            $details->getWeight()->getUnitText(),
            $dimensionUnit,
            $width,
            $height,
            $length,
            $details->getLoadingMeters()
        );
    }

    private function extractEstimatedDelivery(Shipment $shipment): EstimatedDelivery
    {
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
