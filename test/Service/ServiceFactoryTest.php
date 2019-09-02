<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Test\Service;

use Dhl\Sdk\GroupTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\GroupTracking\Service\ServiceFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ServiceFactoryTest extends TestCase
{

    public function testCreateTrackingService()
    {
        $subject = new ServiceFactory();

        HttpClientDiscovery::prependStrategy(MockClientStrategy::class);
        $result = $subject->createTrackingService('randomKey', new NullLogger());
        $this->assertContains(TrackingServiceInterface::class, class_implements($result));
    }
}
