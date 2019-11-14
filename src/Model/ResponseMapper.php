<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\Address;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\DeliveryTimeFrame;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\EstimatedDelivery;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\Person;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\PhysicalAttributes;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\ProofOfDelivery;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\ShipmentEvent;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Response\ShipmentReference;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\TrackResponse;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Details;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Person as ApiPerson;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Place;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Reference;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Shipment;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\ShipmentEvent as ApiShipmentEvent;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\TrackingResponseType;

/**
 * Class ResponseMapper
 *
 * Maps web service response object into public interface types
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class ResponseMapper
{
    /**
     * @var \DateTimeZone
     */
    private $defaultTimeZone;

    /**
     * @var DateTimeValidator
     */
    private $dateTimeValidator;

    /**
     * ResponseMapper constructor.
     *
     * @param \DateTimeZone $defaultTimeZone
     */
    public function __construct(
        \DateTimeZone $defaultTimeZone
    ) {
        $this->defaultTimeZone = $defaultTimeZone;
        $this->dateTimeValidator = new DateTimeValidator();
    }

    /**
     * Transforms API response types into easier usable TrackResponseInterface
     *
     * @param TrackingResponseType $response
     * @return TrackResponseInterface[]
     * @throws \Exception
     * @see TrackResponseInterface
     */
    public function map(TrackingResponseType $response): array
    {
        $results = [];
        /** @var Shipment $shipment */
        foreach ($response->getShipments() as $shipment) {
            $shipmentDetails = $shipment->getDetails();
            $proofOfDelivery = null;
            $physicalAttributes = null;
            $shipmentReferences = [];
            $numberOfPieces = 1;
            $shippingProduct = '';
            $pieceIds = [];
            $sender = null;
            $receiver = null;

            if ($shipmentDetails !== null) {
                if ($shipmentDetails->getProofOfDelivery() !== null) {
                    try {
                        $proofOfDelivery = $this->convertProofOfDelivery($shipmentDetails->getProofOfDelivery());
                    } catch (\Exception $exception) {
                        // no proof of delivery
                    }
                }
                if ($shipmentDetails->getWeight() !== null || $shipmentDetails->getDimensions() !== null) {
                    $physicalAttributes = $this->createPhysicalAttributes($shipmentDetails);
                }
                if ($shipmentDetails->getTotalNumberOfPieces() !== null) {
                    $numberOfPieces = $shipmentDetails->getTotalNumberOfPieces();
                }
                if ($shipmentDetails->getProduct() !== null) {
                    $shippingProduct = $shipmentDetails->getProduct()->getProductName();
                }
                $pieceIds = $shipmentDetails->getPieceIds();
                $shipmentReferences = array_map(
                    function (Reference $reference) {
                        return new ShipmentReference(
                            $reference->getType(),
                            $reference->getNumber()
                        );
                    },
                    $shipmentDetails->getReferences()
                );
                if ($shipmentDetails->getSender() !== null) {
                    $sender = $this->convertPerson($shipmentDetails->getSender());
                }
                if ($shipmentDetails->getReceiver() !== null) {
                    $receiver = $this->convertPerson($shipmentDetails->getReceiver());
                }
            }
            try {
                $shipmentEvents = array_map([$this, 'convertEvent'], $shipment->getEvents());
            } catch (\Exception $exception) {
                $shipmentEvents = [];
            }

            $estimatedDelivery = null;
            if (!empty($shipment->getEstimatedTimeOfDelivery())) {
                try {
                    $estimatedDelivery = $this->extractEstimatedDelivery($shipment);
                } catch (\Exception $exception) {
                    // no estimated delivery date in response
                }
            }

            $trackingId = $shipment->getId();
            $sequence = count($results);
            $arrayKey = $trackingId . '-' . $sequence;
            $results[$arrayKey] = new TrackResponse(
                $trackingId,
                $sequence,
                $shipment->getService(),
                $this->convertEvent($shipment->getStatus()),
                $numberOfPieces,
                $physicalAttributes,
                $shipment->getDestination() !== null ? $this->convertAddress($shipment->getDestination()) : null,
                $shipment->getOrigin() !== null ? $this->convertAddress($shipment->getOrigin()) : null,
                $shippingProduct,
                $estimatedDelivery,
                $sender,
                $receiver,
                $proofOfDelivery,
                $shipmentEvents,
                $pieceIds,
                $shipmentReferences
            );
        }

        return $results;
    }

    /**
     * Returns a \DateTime instance.
     *
     * A lack of time zone designator in the date/time string expresses
     * "local time" (the time zone where the event occurred). To prevent
     * any unintended time zone calculations in such cases, the \DateTime
     * instance gets created with the default time zone passed into the SDK
     * (=the time zone that will be used to display the date in the UI).
     *
     * @param string $time
     *
     * @return \DateTime
     * @throws \Exception
     */
    private function getDateTimeInstance(string $time): \DateTime
    {
        if (!$this->dateTimeValidator->hasTimeZone($time)) {
            $date = new \DateTime($time, $this->defaultTimeZone);
        } else {
            $date = new \DateTime($time);
        }

        return $date;
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
            $this->getDateTimeInstance($proofOfDelivery->getTimestamp()),
            $proofOfDelivery->getDocumentUrl(),
            $proofOfDelivery->getSigned() !== null ? $this->convertPerson($proofOfDelivery->getSigned()) : null
        );
    }

    /**
     * @param ApiPerson $person
     * @return Person
     */
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
            $this->getDateTimeInstance($event->getTimestamp()),
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

    /**
     * @param Shipment $shipment
     * @return EstimatedDelivery
     * @throws \Exception
     */
    private function extractEstimatedDelivery(
        Shipment $shipment
    ): EstimatedDelivery {
        $timeFrame = $shipment->getEstimatedDeliveryTimeFrame() !== null ? new DeliveryTimeFrame(
            $this->getDateTimeInstance($shipment->getEstimatedDeliveryTimeFrame()->getEstimatedFrom()),
            $this->getDateTimeInstance($shipment->getEstimatedDeliveryTimeFrame()->getEstimatedThrough())
        ) : null;

        return new EstimatedDelivery(
            $this->getDateTimeInstance($shipment->getEstimatedTimeOfDelivery()),
            $timeFrame,
            $shipment->getEstimatedTimeOfDeliveryRemark()
        );
    }
}
