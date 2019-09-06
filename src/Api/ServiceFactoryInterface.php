<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Api;

use Psr\Log\LoggerInterface;

/**
 * Interface ServiceFactoryInterface
 *
 * Factory for creating services related to the group tracking API
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface ServiceFactoryInterface
{
    /**
     * Create a service able to retrieve data from the group tracking api
     *
     * @param string $consumerKey
     * @param LoggerInterface $logger
     * @return TrackingServiceInterface
     */
    public function createTrackingService(string $consumerKey, LoggerInterface $logger): TrackingServiceInterface;
}
