<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Expectation;

use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\Shipment;
use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\TrackingResponseType;
use PHPUnit\Framework\Assert;

class JsonSerializerExpectations
{
    public static function assertMappedObjectStructure(string $jsonResponse, TrackingResponseType $responseType)
    {
        $response = json_decode($jsonResponse, false);
        Assert::assertCount(
            count($response->shipments),
            $responseType->getShipments(),
            'Not all shipments in result array'
        );
        foreach ($response->shipments as $id => $shipment) {
            /** @var Shipment $resultShipment */
            $resultShipment = $responseType->getShipments()[$id];
            Assert::assertNotNull($resultShipment, 'Shipment could not be found');
            Assert::assertSame($shipment->service, $resultShipment->getService(), 'Service name does not match');
            Assert::assertCount(count($shipment->events), $resultShipment->getEvents(), 'Event count does not match');

            if (isset($shipment->details->weight)) {
                Assert::assertEquals(
                    (float) $shipment->details->weight->value,
                    $resultShipment->getDetails()->getWeight()->getValue(),
                    'Weight mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    $shipment->details->weight->unitText,
                    $resultShipment->getDetails()->getWeight()->getUnitText(),
                    'Weight unit mismatch for ' . $shipment->id
                );
            }
            if (isset($shipment->details->dimensions)) {
                $dimensions = $shipment->details->dimensions;
                Assert::assertSame(
                    $dimensions->height->unitText,
                    $resultShipment->getDetails()->getDimensions()->getHeight()->getUnitText(),
                    'Dimension unit mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    (float) $dimensions->height->value,
                    $resultShipment->getDetails()->getDimensions()->getHeight()->getValue(),
                    'Height mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    (float) $dimensions->length->value,
                    $resultShipment->getDetails()->getDimensions()->getLength()->getValue(),
                    'Length mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    (float) $dimensions->width->value,
                    $resultShipment->getDetails()->getDimensions()->getWidth()->getValue(),
                    'Width mismatch for ' . $shipment->id
                );
            }

            if (isset($shipment->details->proofOfDelivery)) {
                $proofOfDelivery = $shipment->details->proofOfDelivery;
                Assert::assertSame(
                    $proofOfDelivery->documentUrl,
                    $resultShipment->getDetails()->getProofOfDelivery()->getDocumentUrl(),
                    'Proof of Delivery DocumentUrl mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    $proofOfDelivery->timestamp,
                    $resultShipment->getDetails()->getProofOfDelivery()->getTimestamp(),
                    'Proof of Delivery Timestamp mismatch for ' . $shipment->id
                );
                Assert::assertSame(
                    $proofOfDelivery->signed->name,
                    $resultShipment->getDetails()->getProofOfDelivery()->getSigned()->getName(),
                    'Proof of Delivery Signed mismatch for ' . $shipment->id
                );
            }

            if (isset($shipment->estimatedTimeOfDelivery)) {
                Assert::assertNotNull(
                    $resultShipment->getEstimatedTimeOfDelivery(),
                    'No estimated delivery time for' . $shipment->id
                );
                if (isset($shipment->estimatedDeliveryTimeFrame)) {
                    Assert::assertSame(
                        $shipment->estimatedDeliveryTimeFrame->estimatedFrom,
                        $resultShipment->getEstimatedDeliveryTimeFrame()
                                       ->getEstimatedFrom(),
                        'Estimated delivery timeframe start mismatch for ' . $shipment->id
                    );
                    Assert::assertSame(
                        $shipment->estimatedDeliveryTimeFrame->estimatedThrough,
                        $resultShipment->getEstimatedDeliveryTimeFrame()
                                       ->getEstimatedThrough(),
                        'Estimated delivery timeframe end mismatch for ' . $shipment->id
                    );
                }
            }
        }
    }
}
