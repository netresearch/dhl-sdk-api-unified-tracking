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
use Dhl\Sdk\GroupTracking\Test\Expectation\TrackingServiceTestExpectation;
use Dhl\Sdk\GroupTracking\Test\Fixture\TrackResponse;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\Formatter\FullHttpMessageFormatter;
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

        $headerPlugin = new HeaderDefaultsPlugin(
            [
                'DHL-API-Key' => 'MY_TEST_KEY',
                'Accept' => 'application/json',
            ]
        );
        $logger = new TestLogger();
        $loggerPlugin = new LoggerPlugin($logger, new FullHttpMessageFormatter(null));
        $clientFactory = new PluginClientFactory();

        $subject = new TrackingService(
            $clientFactory->createClient(
                new PluginClient($client),
                [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
            ),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper()
        );

        /** @var TrackResponseInterface[] $result */
        $result = $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');

        TrackingServiceTestExpectation::assertCommunicationLogged($jsonResponse, $client->getLastRequest(), $logger);
        TrackingServiceTestExpectation::assertResultCountMatches($jsonResponse, $result);
        TrackingServiceTestExpectation::assertResponseStructureMatches($jsonResponse, $result);
    }

    /**
     * @dataProvider errorDataProvider
     * @test
     * @param string $jsonResponse
     * @throws Dhl\Sdk\GroupTracking\Exception\ClientException
     * @throws Dhl\Sdk\GroupTracking\Exception\ServerException
     * @throws Dhl\Sdk\GroupTracking\Exception\ServiceException
     */
    public function testRetrieveTrackingInformationError(string $jsonResponse)
    {
        $response = json_decode($jsonResponse, true);
        $this->expectException(ClientException::class);
        if ($response) {
            $this->expectExceptionCode($response['status']);
            $this->expectExceptionMessageRegExp("#{$response['title']}#");
        }

        $client = new Client();
        $messageFactory = MessageFactoryDiscovery::find();
        $httpResponse = $messageFactory->createResponse($response['status'], $response['title'], [], $jsonResponse);

        $client->setDefaultResponse($httpResponse);
        $headerPlugin = new HeaderDefaultsPlugin(
            [
                'DHL-API-Key' => 'MY_TEST_KEY',
                'Accept' => 'application/json',
            ]
        );
        $logger = new TestLogger();
        $loggerPlugin = new LoggerPlugin($logger, new FullHttpMessageFormatter(null));
        $clientFactory = new PluginClientFactory();

        $subject = new TrackingService(
            $clientFactory->createClient(
                new PluginClient($client),
                [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
            ),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper()
        );

        try {
            $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');
        } catch (ClientException $exception) {
            $lastRequest = $client->getLastRequest();

            TrackingServiceTestExpectation::assertErrorLogged($jsonResponse, $logger);
            TrackingServiceTestExpectation::assertCommunicationLogged($jsonResponse, $lastRequest, $logger);
            throw $exception;
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
