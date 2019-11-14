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
     * @dataProvider responseJsonProvider
     */
    public function testDecode(string $jsonResponse)
    {
        $subject = new JsonSerializer();
        $responseObject = $subject->decode($jsonResponse);

        JsonSerializerExpectations::assertMappedObjectStructure($jsonResponse, $responseObject);
    }

    /**
     * @return string[]
     */
    public function responseJsonProvider(): array
    {
        return TrackResponse::getSuccessFullTrackResponses();
    }
}
