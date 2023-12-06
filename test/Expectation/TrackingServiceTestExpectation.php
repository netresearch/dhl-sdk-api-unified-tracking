<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Expectation;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\RequestInterface;
use Psr\Log\Test\TestLogger;

class TrackingServiceTestExpectation
{
    /**
     * Assert that there was an error logged for error responses
     * @throws \JsonException
     */
    public static function assertErrorLogged(string $responseJson, TestLogger $logger): void
    {
        $errorResponse = json_decode($responseJson, false, 512, JSON_THROW_ON_ERROR);

        Assert::assertTrue($logger->hasErrorRecords(), 'No error logged');
        Assert::assertTrue($logger->hasErrorThatContains($errorResponse->title), 'Error message not logged');
    }

    /**
     * Assert that the API requests and responses were logged to the logger as either info or error
     */
    public static function assertCommunicationLogged(
        string $responseJson,
        RequestInterface $request,
        TestLogger $logger
    ): void {
        Assert::assertTrue($logger->hasInfoRecords(), 'Logger has no info messages');

        $statusRegex = '|^HTTP/\d\.\d\s\d{3}\s[\w\s]+$|m';
        $hasStatusCode = $logger->hasInfoThatMatches($statusRegex) || $logger->hasErrorThatMatches($statusRegex);
        $hasRequest = $logger->hasInfoThatContains($request->getUri()->getQuery())
                      || $logger->hasErrorThatContains($request->getUri()->getQuery());
        $hasResponse = $logger->hasInfoThatContains($responseJson) || $logger->hasErrorThatContains($responseJson);

        Assert::assertTrue($hasStatusCode, 'Logged messages do not contain status code.');
        Assert::assertTrue($hasRequest, 'Logged messages do not contain request');
        Assert::assertTrue($hasResponse, 'Logged messages do not contain response');
    }

    /**
     * Assert that all response objects were properly mapped and are present in the form [trackingId => resultObject]
     *
     * @param TrackResponseInterface[] $result
     */
    public static function assertResultCountMatches(string $jsonResponse, array $result): void
    {
        $response = json_decode($jsonResponse, false, 512, JSON_THROW_ON_ERROR);
        Assert::assertCount(count($response->shipments), $result);
        foreach ($response->shipments as $key => $shipment) {
            $index = $shipment->id . '-' . $key;
            Assert::assertArrayHasKey($index, $result);
            Assert::assertInstanceOf(TrackResponseInterface::class, $result[$index]);
        }
    }

    /**
     * Assert that all response objects have been converted and the data is in the correct places
     *
     * @param TrackResponseInterface[] $result
     */
    public static function assertResponseStructureMatches(string $jsonResponse, array $result): void
    {
        $response = json_decode($jsonResponse, false, 512, JSON_THROW_ON_ERROR);
        foreach ($response->shipments as $key => $shipment) {
            $resultInstance = $result[$shipment->id . '-' . $key];
            Assert::assertEquals($shipment->status->statusCode, $resultInstance->getLatestStatus()->getStatusCode());
            Assert::assertEquals($shipment->service, $resultInstance->getService());
            Assert::assertCount(count($shipment->events), $resultInstance->getStatusEvents());
            if (isset($shipment->details->weight)) {
                Assert::assertEquals(
                    (float) $shipment->details->weight->value,
                    $resultInstance->getPhysicalAttributes()->getWeight()
                );
                Assert::assertSame(
                    $shipment->details->weight->unitText,
                    $resultInstance->getPhysicalAttributes()->getWeightUom()
                );
            }
            if (isset($shipment->details->dimensions)) {
                $dimensions = $shipment->details->dimensions;
                Assert::assertSame(
                    $dimensions->height->unitText,
                    $resultInstance->getPhysicalAttributes()->getDimensionUom()
                );
                Assert::assertSame(
                    (float) $dimensions->height->value,
                    $resultInstance->getPhysicalAttributes()->getHeight()
                );
                Assert::assertSame(
                    (float) $dimensions->length->value,
                    $resultInstance->getPhysicalAttributes()->getLength()
                );
                Assert::assertSame(
                    (float) $dimensions->width->value,
                    $resultInstance->getPhysicalAttributes()->getWidth()
                );
            }

            if (isset($shipment->details->proofOfDelivery)) {
                $proofOfDelivery = $shipment->details->proofOfDelivery;
                Assert::assertSame(
                    $proofOfDelivery->documentUrl,
                    $resultInstance->getProofOfDelivery()->getDocumentUrl()
                );
                Assert::assertSame(
                    strtotime((string) $proofOfDelivery->timestamp),
                    $resultInstance->getProofOfDelivery()->getTimeStamp()->getTimestamp()
                );
                Assert::assertSame(
                    $proofOfDelivery->signed->name,
                    $resultInstance->getProofOfDelivery()->getSignee()->getName()
                );
            }

            if (isset($shipment->estimatedTimeOfDelivery)) {
                Assert::assertNotNull($resultInstance->getEstimatedDeliveryTime());
                if (isset($shipment->estimatedDeliveryTimeFrame)) {
                    Assert::assertSame(
                        strtotime((string) $shipment->estimatedDeliveryTimeFrame->estimatedFrom),
                        $resultInstance->getEstimatedDeliveryTime()
                                       ->getTimeFrame()
                                       ->getStart()
                                       ->getTimestamp()
                    );
                    Assert::assertSame(
                        strtotime((string) $shipment->estimatedDeliveryTimeFrame->estimatedThrough),
                        $resultInstance->getEstimatedDeliveryTime()
                                       ->getTimeFrame()
                                       ->getEnd()
                                       ->getTimestamp()
                    );
                }
            }
        }
    }
}
