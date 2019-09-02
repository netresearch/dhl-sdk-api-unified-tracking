<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Service;

use Dhl\Sdk\GroupTracking\Api\ServiceFactoryInterface;
use Dhl\Sdk\GroupTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\GroupTracking\Http\Plugin\TrackingErrorPlugin;
use Dhl\Sdk\GroupTracking\Model\ResponseMapper;
use Dhl\Sdk\GroupTracking\Serializer\JsonSerializer;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\Formatter\FullHttpMessageFormatter;
use Psr\Log\LoggerInterface;

class ServiceFactory implements ServiceFactoryInterface
{
    public function createTrackingService(string $consumerKey, LoggerInterface $logger): TrackingServiceInterface
    {
        $headerPlugin = new HeaderDefaultsPlugin(
            [
                'DHL-API-Key' => $consumerKey,
                'Accept' => 'application/json',
            ]
        );
        $loggerPlugin = new LoggerPlugin($logger, new FullHttpMessageFormatter(4096));
        $requestFactory = MessageFactoryDiscovery::find();
        $jsonSerializer = new JsonSerializer();

        $clientFactory = new PluginClientFactory();
        $client = $clientFactory->createClient(
            new PluginClient(HttpClientDiscovery::find()),
            [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
        );
        $responseMapper = new ResponseMapper();

        return new TrackingService($client, $requestFactory, $jsonSerializer, $responseMapper);
    }
}
