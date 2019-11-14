<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Service;

use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Service\ServiceFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ServiceFactoryTest extends TestCase
{
    public function testCreateTrackingService()
    {
        $subject = new ServiceFactory();
        $timezone = new \DateTimeZone('Europe/Berlin');

        HttpClientDiscovery::prependStrategy(MockClientStrategy::class);
        $result = $subject->createTrackingService('randomKey', new NullLogger(), $timezone);
        $this->assertContains(TrackingServiceInterface::class, class_implements($result));
    }
}
