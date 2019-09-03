<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Test\Expectation;

use Dhl\Sdk\GroupTracking\Api\Data\TrackResponseInterface;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\RequestInterface;
use Psr\Log\Test\TestLogger;

class TrackingServiceTestExpectation
{
    /**
     * Assert that there was an error logged for error responses
     *
     * @param string $responseJson
     * @param TestLogger $logger
     */
    public static function assertErrorLogged(string $responseJson, TestLogger $logger)
    {
        $errorResponse = json_decode($responseJson, false);

        Assert::assertTrue($logger->hasErrorRecords(), 'No error logged');
        Assert::assertTrue($logger->hasErrorThatContains($errorResponse->title), 'Error message not logged');
    }

    /**
     * Assert that the API requests and responses were logged to the logger as either info or error
     *
     * @param string $responseJson
     * @param RequestInterface $request
     * @param TestLogger $logger
     */
    public static function assertCommunicationLogged(
        string $responseJson,
        RequestInterface $request,
        TestLogger $logger
    ) {
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
     * @param string $jsonResponse
     * @param TrackResponseInterface[] $result
     */
    public static function assertResultCountMatches(string $jsonResponse, array $result)
    {
        $response = json_decode($jsonResponse, false);
        Assert::assertCount(count($response->shipments), $result);
        foreach ($response->shipments as $shipment) {
            Assert::assertArrayHasKey((string) $shipment->id, $result);
            Assert::assertInstanceOf(TrackResponseInterface::class, $result[$shipment->id]);
        }
    }
}
