<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Test\Serializer;

use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use Dhl\Sdk\Group\Tracking\Test\Fixture\TrackResponse;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{

    public function testDecode()
    {
        $jsonResponse = TrackResponse::getSuccessFullTrackResponse();

        $subject = new JsonSerializer();
        $responseObject = $subject->decode($jsonResponse);

        $this->assertCount(1, $responseObject->getShipments());
    }
}
