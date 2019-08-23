<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Api;

use Psr\Log\LoggerInterface;

interface ServiceFactoryInterface
{
    public function createTrackingService(string $consumerKey, LoggerInterface $logger);
}
