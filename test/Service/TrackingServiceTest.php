<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Test\Service;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\Group\Tracking\Model\ResponseMapper;
use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use Dhl\Sdk\Group\Tracking\Service\TrackingService;
use Dhl\Sdk\Group\Tracking\Test\Fixture\TrackResponse;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Client\Exception\HttpException;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class TrackingServiceTest extends TestCase
{

    /**
     * @dataProvider successDataProvider
     * @test
     * @param string $jsonResponse
     */
    public function testRetrieveTrackingInformationSuccess(string $jsonResponse)
    {
        $messageFactory = MessageFactoryDiscovery::find();
        $response = $messageFactory->createResponse(200, null, [], $jsonResponse);
        $client = new Client($messageFactory);

        $client->addResponse($response);

        $subject = new TrackingService(
            $this->createPluginClient($client),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper()
        );

        $data = json_decode($jsonResponse, true)['shipments'][0];

        /** @var TrackResponseInterface $result */
        $result = $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');

        $this->assertSame((string) $data['id'], $result->getId());
    }

    /**
     * @param $mockClient
     * @return PluginClient
     */
    private function createPluginClient(Client $mockClient): PluginClient
    {
        $headerPlugin = new HeaderDefaultsPlugin(
            [
                'DHL-API-Key' => 'MY_TEST_KEY',
                'Accept' => 'application/json',
            ]
        );
        $loggerPlugin = new LoggerPlugin(new NullLogger());
        $clientFactory = new PluginClientFactory();

        return $clientFactory->createClient(
            new PluginClient($mockClient),
            [$headerPlugin, $loggerPlugin]
        );
    }

    /**
     * @dataProvider errorDataProvider
     * @test
     * @param string $jsonResponse
     */
    public function testRetrieveTrackingInformationError(string $jsonResponse)
    {
        $client = new Client();
        $messageFactory = MessageFactoryDiscovery::find();
        $response = $messageFactory->createResponse(404, null, [], $jsonResponse);

        $client->addResponse($response);

        $subject = new TrackingService(
            $this->createPluginClient($client),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper()
        );

        $result = $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');
    }

    public function testRetrieveTrackingInformationException()
    {
        $client = new Client();
        $responseFactory = MessageFactoryDiscovery::find();
        $exception = new HttpException('Computer says no');
        $client->addException($exception);
    }

    public function successDataProvider(): array
    {
        return TrackResponse::getSuccessFullTrackResponses();
    }

    public function errorDataProvider(): array
    {
        return TrackResponse::getNotFoundTrackResponse();
    }
}
