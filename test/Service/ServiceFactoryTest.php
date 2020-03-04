<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Service;

use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;
use Dhl\Sdk\UnifiedTracking\Service\ServiceFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @backupStaticAttributes enabled
 */
class ServiceFactoryTest extends TestCase
{
    /**
     * Scenario: a service instance is to be created.
     *
     * Assert that an instance of {@see TrackingServiceInterface} is created.
     *
     * @test
     * @throws ServiceException
     */
    public function factorySuccess(): void
    {
        // prepend discovery strategy. will be reset via `backupStaticAttributes` annotation.
        HttpClientDiscovery::prependStrategy(MockClientStrategy::class);

        $factory = new ServiceFactory();
        $service = $factory->createTrackingService('randomKey', new NullLogger(), new \DateTimeZone('Europe/Berlin'));
        self::assertInstanceOf(TrackingServiceInterface::class, $service);
    }

    /**
     * Scenario: a service instance is to be created but no HTTP client implementation is available.
     *
     * Assert that an instance of {@see ServiceException} is thrown.
     *
     * @test
     *
     * @throws ServiceException
     */
    public function factoryError(): void
    {
        // unset all discovery strategies. will be reset via `backupStaticAttributes` annotation.
        HttpClientDiscovery::setStrategies([]);

        $this->expectException(ServiceException::class);

        $factory = new ServiceFactory();
        $factory->createTrackingService('randomKey', new NullLogger(), new \DateTimeZone('Europe/Berlin'));
    }
}
