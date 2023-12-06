<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\DeliveryTimeFrameInterface;

class DeliveryTimeFrame implements DeliveryTimeFrameInterface
{
    public function __construct(private readonly \DateTime $start, private readonly \DateTime $end)
    {
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }
}
