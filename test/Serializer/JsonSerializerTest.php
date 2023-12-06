<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Serializer;

use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
use Dhl\Sdk\UnifiedTracking\Test\Expectation\JsonSerializerExpectations;
use Dhl\Sdk\UnifiedTracking\Test\Fixture\TrackResponse;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    /**
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('responseJsonProvider')]
    public function testDecode(string $jsonResponse): void
    {
        $subject = new JsonSerializer();
        $responseObject = $subject->decode($jsonResponse);

        JsonSerializerExpectations::assertMappedObjectStructure($jsonResponse, $responseObject);
    }

    /**
     * @return string[]
     */
    public static function responseJsonProvider(): array
    {
        return TrackResponse::getSuccessFullTrackResponses();
    }
}
