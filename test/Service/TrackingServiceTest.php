<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Test\Service;

use Dhl\Sdk\GroupTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\GroupTracking\Exception\ClientException;
use Dhl\Sdk\GroupTracking\Http\Plugin\TrackingErrorPlugin;
use Dhl\Sdk\GroupTracking\Model\ResponseMapper;
use Dhl\Sdk\GroupTracking\Serializer\JsonSerializer;
use Dhl\Sdk\GroupTracking\Service\TrackingService;
use Dhl\Sdk\GroupTracking\Test\Fixture\TrackResponse;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

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
        $loggerPlugin = new LoggerPlugin(new TestLogger());
        $clientFactory = new PluginClientFactory();

        return $clientFactory->createClient(
            new PluginClient($mockClient),
            [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
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
        $response = json_decode($jsonResponse, true);
        $httpResponnse = $messageFactory->createResponse($response['status'], $response['title'], [], $jsonResponse);

        $client->setDefaultResponse($httpResponnse);

        $subject = new TrackingService(
            $this->createPluginClient($client),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper()
        );

        try {
            $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');
        } catch (ClientException $exception) {
            $lastRequest = $client->getLastRequest();

        }
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
