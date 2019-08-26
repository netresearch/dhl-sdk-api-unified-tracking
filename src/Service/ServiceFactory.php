<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Service;

use Dhl\Sdk\Group\Tracking\Api\ServiceFactoryInterface;
use Dhl\Sdk\Group\Tracking\Api\TrackingServiceInterface;
use Dhl\Sdk\Group\Tracking\Model\ResponseMapper;
use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
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
        $loggerPlugin = new LoggerPlugin($logger);
        $requestFactory = MessageFactoryDiscovery::find();
        $jsonSerializer = new JsonSerializer();

        $clientFactory = new PluginClientFactory();
        $client = $clientFactory->createClient(
            new PluginClient(HttpClientDiscovery::find()),
            [$headerPlugin, $loggerPlugin]
        );
        $responseMapper = new ResponseMapper();

        return new TrackingService($client, $requestFactory, $jsonSerializer, $responseMapper);
    }
}
