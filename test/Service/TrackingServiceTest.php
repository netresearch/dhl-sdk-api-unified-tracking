<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Service;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Exception\ClientException;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;
use Dhl\Sdk\UnifiedTracking\Http\Plugin\TrackingErrorPlugin;
use Dhl\Sdk\UnifiedTracking\Model\ResponseMapper;
use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
use Dhl\Sdk\UnifiedTracking\Service\TrackingService;
use Dhl\Sdk\UnifiedTracking\Test\Expectation\TrackingServiceTestExpectation;
use Dhl\Sdk\UnifiedTracking\Test\Fixture\TrackResponse;
use Http\Client\Common\Exception\LoopException;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\RequestException;
use Http\Client\Exception\TransferException;
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
     * @throws Dhl\Sdk\UnifiedTracking\Exception\ClientException
     * @throws Dhl\Sdk\UnifiedTracking\Exception\ServerException
     * @throws Dhl\Sdk\UnifiedTracking\Exception\ServiceException
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

    /**
     * @param \Exception $exception
     * @throws ServiceException
     * @dataProvider exceptionProvider
     */
    public function testExceptionMasking(\Exception $exception)
    {
        $this->expectException(ServiceException::class);

        $client = new Client();
        $messageFactory = MessageFactoryDiscovery::find();

        $client->setDefaultException($exception);
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

        $subject->retrieveTrackingInformation('trackId');
    }

    /**
     * @return array
     */
    public function exceptionProvider(): array
    {
        $messageFactory = MessageFactoryDiscovery::find();

        $request = $messageFactory->createRequest('GET', 'www');

        return [
            HttpException::class => [
                'exception' => new HttpException(
                    'ERROR',
                    $request,
                    $messageFactory->createResponse(500)
                ),
            ],
            NetworkException::class => [
                'exception' => new NetworkException(
                    'ERROR',
                    $request
                ),
            ],
            LoopException::class => [
                'exception' => new LoopException(
                    'ERROR',
                    $request
                ),
            ],
            RequestException::class => [
                'exception' => new RequestException(
                    'ERROR',
                    $request
                ),
            ],
            TransferException::class => ['exception' => new TransferException('ERROR')],
        ];
    }
}
