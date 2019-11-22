<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api;

use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;
use Psr\Log\LoggerInterface;

/**
 * Interface ServiceFactoryInterface
 *
 * Factory for creating services related to the unified tracking API
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface ServiceFactoryInterface
{
    /**
     * Create a service able to retrieve a shipment's tracking history from the Unified Tracking API.
     *
     * Some date strings from web service are expressed as "local time" with no
     * time zone designator. Pass in the user's (UI) time zone to have these
     * dates displayed properly.
     *
     * @param string $consumerKey
     * @param LoggerInterface $logger
     * @param \DateTimeZone $defaultTimeZone
     *
     * @return TrackingServiceInterface
     *
     * @throws ServiceException
     */
    public function createTrackingService(
        string $consumerKey,
        LoggerInterface $logger,
        \DateTimeZone $defaultTimeZone
    ): TrackingServiceInterface;
}
