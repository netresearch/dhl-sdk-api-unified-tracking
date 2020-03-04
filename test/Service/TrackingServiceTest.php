<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Service;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedServiceException;
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
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Formatter\FullHttpMessageFormatter;
use Http\Mock\Client;
use Nyholm\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class TrackingServiceTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function successDataProvider(): array
    {
        return TrackResponse::getSuccessFullTrackResponses();
    }

    /**
     * @return string[][]
     */
    public function errorDataProvider(): array
    {
        return TrackResponse::getNotFoundTrackResponse();
    }

    /**
     * @return TransferException[][]
     */
    public function exceptionProvider(): array
    {
        $messageFactory = Psr17FactoryDiscovery::findRequestFactory();

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

    /**
     * @test
     * @dataProvider successDataProvider
     *
     * @param string $jsonResponse
     * @throws ServiceException
     */
    public function retrieveTrackingInformationSuccess(string $jsonResponse)
    {
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $response = $responseFactory->createResponse()->withBody($streamFactory->createStream($jsonResponse));
        $client = new Client();

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
        $timezone = new \DateTimeZone('Europe/Berlin');

        $subject = new TrackingService(
            $clientFactory->createClient(
                new PluginClient($client),
                [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
            ),
            $requestFactory,
            new JsonSerializer(),
            new ResponseMapper($timezone)
        );

        /** @var TrackResponseInterface[] $result */
        $result = $subject->retrieveTrackingInformation(
            'trackingId',
            'express',
            'DE',
            'US',
            '04229'
        );

        TrackingServiceTestExpectation::assertCommunicationLogged($jsonResponse, $client->getLastRequest(), $logger);
        TrackingServiceTestExpectation::assertResultCountMatches($jsonResponse, $result);
        TrackingServiceTestExpectation::assertResponseStructureMatches($jsonResponse, $result);
    }

    /**
     * @test
     * @dataProvider errorDataProvider
     *
     * @param string $jsonResponse
     * @throws ServiceException
     */
    public function retrieveTrackingInformationError(string $jsonResponse): void
    {
        $response = json_decode($jsonResponse, true);

        if ($response['status'] === 401) {
            $this->expectException(AuthenticationException::class);
            $this->expectExceptionMessageRegExp('/^Authentication failed\./');
        } else {
            $this->expectException(DetailedServiceException::class);
        }

        $this->expectExceptionCode($response['status']);
        $this->expectExceptionMessageRegExp("#{$response['title']}#");

        $client = new Client();
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpResponse = $responseFactory->createResponse($response['status'], $response['title'])
            ->withBody($streamFactory->createStream($jsonResponse))
            ->withHeader('Content-Type', 'application/json');

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
        $timezone = new \DateTimeZone('Europe/Berlin');

        $subject = new TrackingService(
            $clientFactory->createClient(
                new PluginClient($client),
                [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
            ),
            $requestFactory,
            new JsonSerializer(),
            new ResponseMapper($timezone)
        );

        try {
            $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');
        } catch (ServiceException $exception) {
            $lastRequest = $client->getLastRequest();

            TrackingServiceTestExpectation::assertErrorLogged($jsonResponse, $logger);
            TrackingServiceTestExpectation::assertCommunicationLogged($jsonResponse, $lastRequest, $logger);
            throw $exception;
        }
    }

    /**
     * Assert that HTTP client exceptions are transformed into service exceptions.
     *
     * @test
     * @dataProvider exceptionProvider
     *
     * @param \Exception $exception
     * @throws ServiceException
     */
    public function exceptionMasking(\Exception $exception)
    {
        $this->expectException(ServiceException::class);

        $client = new Client();
        $messageFactory = Psr17FactoryDiscovery::findRequestFactory();

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
        $timezone = new \DateTimeZone('Europe/Berlin');

        $subject = new TrackingService(
            $clientFactory->createClient(
                new PluginClient($client),
                [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
            ),
            $messageFactory,
            new JsonSerializer(),
            new ResponseMapper($timezone)
        );

        $subject->retrieveTrackingInformation('trackId');
    }
}
