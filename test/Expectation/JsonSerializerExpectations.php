<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Test\Expectation;

use Dhl\Sdk\GroupTracking\Model\Tracking\Types\Shipment;
use Dhl\Sdk\GroupTracking\Model\Tracking\Types\TrackingResponseType;
use PHPUnit\Framework\Assert;

class JsonSerializerExpectations
{
    public static function assertMappedObjectStructure(string $jsonResponse, TrackingResponseType $responseType)
    {
        $response = json_decode($jsonResponse, false);
        Assert::assertCount(count($response->shipments), $responseType->getShipments());
        foreach ($response->shipments as $shipment) {
            /** @var Shipment $resultShipment */
            $resultShipment = current(
                array_filter(
                    $responseType->getShipments(),
                    static function (Shipment $mappedShipment) use ($shipment) {
                        return (string) $shipment->id === $mappedShipment->getId();
                    }
                )
            );
            Assert::assertNotNull($resultShipment);
            Assert::assertSame($shipment->service, $resultShipment->getService());
            Assert::assertCount(count($shipment->events), $resultShipment->getEvents());

            if (isset($shipment->details->weight)) {
                Assert::assertEquals(
                    (float) $shipment->details->weight->value,
                    $resultShipment->getDetails()->getWeight()->getValue()
                );
                Assert::assertSame(
                    $shipment->details->weight->unitText,
                    $resultShipment->getDetails()->getWeight()->getUnitText()
                );
            }
            if (isset($shipment->details->dimensions)) {
                $dimensions = $shipment->details->dimensions;
                Assert::assertSame(
                    $dimensions->height->unitText,
                    $resultShipment->getDetails()->getDimensions()->getHeight()->getUnitText()
                );
                Assert::assertSame(
                    (float) $dimensions->height->value,
                    $resultShipment->getDetails()->getDimensions()->getHeight()->getValue()
                );
                Assert::assertSame(
                    (float) $dimensions->length->value,
                    $resultShipment->getDetails()->getDimensions()->getLength()->getValue()
                );
                Assert::assertSame(
                    (float) $dimensions->width->value,
                    $resultShipment->getDetails()->getDimensions()->getWidth()->getValue()
                );
            }

            if (isset($shipment->details->proofOfDelivery)) {
                $proofOfDelivery = $shipment->details->proofOfDelivery;
                Assert::assertSame(
                    $proofOfDelivery->documentUrl,
                    $resultShipment->getDetails()->getProofOfDelivery()->getDocumentUrl()
                );
                Assert::assertSame(
                    $proofOfDelivery->timestamp,
                    $resultShipment->getDetails()->getProofOfDelivery()->getTimestamp()
                );
                Assert::assertSame(
                    $proofOfDelivery->signed->name,
                    $resultShipment->getDetails()->getProofOfDelivery()->getSigned()->getName()
                );
            }

            if (isset($shipment->estimatedTimeOfDelivery)) {
                Assert::assertNotNull($resultShipment->getEstimatedTimeOfDelivery());
                if (isset($shipment->estimatedDeliveryTimeFrame)) {
                    Assert::assertSame(
                        $shipment->estimatedDeliveryTimeFrame->estimatedFrom,
                        $resultShipment->getEstimatedDeliveryTimeFrame()
                                       ->getEstimatedFrom()
                    );
                    Assert::assertSame(
                        $shipment->estimatedDeliveryTimeFrame->estimatedThrough,
                        $resultShipment->getEstimatedDeliveryTimeFrame()
                                       ->getEstimatedThrough()
                    );
                }
            }
        }
    }
}
