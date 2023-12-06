<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Service;

use Dhl\Sdk\UnifiedTracking\Api\ServiceFactoryInterface;
use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceExceptionFactory;
use Dhl\Sdk\UnifiedTracking\Http\Plugin\TrackingErrorPlugin;
use Dhl\Sdk\UnifiedTracking\Model\ResponseMapper;
use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Formatter\FullHttpMessageFormatter;
use Psr\Log\LoggerInterface;

class ServiceFactory implements ServiceFactoryInterface
{
    public function createTrackingService(
        string $consumerKey,
        LoggerInterface $logger,
        \DateTimeZone $defaultTimeZone
    ): TrackingServiceInterface {
        $headerPlugin = new HeaderDefaultsPlugin(
            [
                'DHL-API-Key' => $consumerKey,
                'Accept' => 'application/json',
            ]
        );

        try {
            $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
            $httpClient = Psr18ClientDiscovery::find();
        } catch (NotFoundException $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        $loggerPlugin = new LoggerPlugin($logger, new FullHttpMessageFormatter(null));
        $jsonSerializer = new JsonSerializer();
        $clientFactory = new PluginClientFactory();

        $client = $clientFactory->createClient(
            $httpClient,
            [
                $headerPlugin,
                $loggerPlugin,
                new TrackingErrorPlugin()
            ]
        );

        $responseMapper = new ResponseMapper($defaultTimeZone);

        return new TrackingService($client, $requestFactory, $jsonSerializer, $responseMapper);
    }
}
