<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Service;

use Dhl\Sdk\UnifiedTracking\Api\ServiceFactoryInterface;
use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Http\Plugin\TrackingErrorPlugin;
use Dhl\Sdk\UnifiedTracking\Model\ResponseMapper;
use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
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
        $loggerPlugin = new LoggerPlugin($logger, new FullHttpMessageFormatter(null));
        $requestFactory = MessageFactoryDiscovery::find();
        $jsonSerializer = new JsonSerializer();

        $clientFactory = new PluginClientFactory();
        $client = $clientFactory->createClient(
            HttpClientDiscovery::find(),
            [$headerPlugin, $loggerPlugin, new TrackingErrorPlugin()]
        );
        $responseMapper = new ResponseMapper();

        return new TrackingService($client, $requestFactory, $jsonSerializer, $responseMapper);
    }
}
