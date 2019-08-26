<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Test\Service;

use Dhl\Sdk\Group\Tracking\Model\ResponseMapper;
use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use Dhl\Sdk\Group\Tracking\Service\TrackingService;
use Dhl\Sdk\Group\Tracking\Test\Fixture\TrackResponse;
use Http\Client\Exception\HttpException;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;

class TrackingServiceTest extends TestCase
{

    public function testRetrieveTrackingInformationSuccess()
    {
        $responseFactory = MessageFactoryDiscovery::find();
        $response = $responseFactory->createResponse(200, null, [], TrackResponse::getSuccessFullTrackResponse());
        $client = new Client($responseFactory);

        $client->addResponse($response);

        $subject = new TrackingService($client, $responseFactory, new JsonSerializer(), new ResponseMapper());

        /** @var \Dhl\Sdk\Group\Tracking\Model\Tracking\TrackResponse $result */
        $result = $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');

        $rawResponse = $result->getOriginResponse();
    }

    public function testRetrieveTrackingInformationError()
    {
        $client = new Client();
        $responseFactory = MessageFactoryDiscovery::find();
        $response = $responseFactory->createResponse(404, null, [], TrackResponse::getNotFoundTrackResponse());

        $client->addResponse($response);

        $subject = new TrackingService($client, $responseFactory, new JsonSerializer(), new ResponseMapper());

        $result = $subject->retrieveTrackingInformation('trackingId', 'express', 'DE', 'US', '04229');
    }

    public function testRetrieveTrackingInformationException()
    {
        $client = new Client();
        $responseFactory = MessageFactoryDiscovery::find();
        $exception = new HttpException('Computer says no');
        $client->addException($exception);
    }
}
