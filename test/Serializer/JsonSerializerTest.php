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

    /**
     * @dataProvider responseJsonProvider
     */
    public function testDecode(string $jsonResponse)
    {
        $data = json_decode($jsonResponse, true);
        $subject = new JsonSerializer();
        $responseObject = $subject->decode($jsonResponse);

        $this->assertCount(1, $responseObject->getShipments());

        $shipment = $responseObject->getShipments()[0];
        $this->assertEquals($data["shipments"][0]['id'], $shipment->getId());
        $this->assertEquals($data["shipments"][0]['service'], $shipment->getService());
    }

    /**
     * @return string[]
     */
    public function responseJsonProvider(): array
    {
        return TrackResponse::getSuccessFullTrackResponses();
    }
}
