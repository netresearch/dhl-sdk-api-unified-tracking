<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Test\Expectation;

use PHPUnit\Framework\Assert;
use Psr\Http\Message\RequestInterface;
use Psr\Log\Test\TestLogger;

class TrackingServiceTestExpectation
{
    public static function assertErrorLogged(string $responseJson, TestLogger $logger)
    {
        $errorResponse = json_decode($responseJson, false);

        Assert::assertTrue($logger->hasErrorRecords(), 'No error logged');
        Assert::assertTrue($logger->hasErrorThatContains($errorResponse->title), 'Error message not logged');
    }

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
}
