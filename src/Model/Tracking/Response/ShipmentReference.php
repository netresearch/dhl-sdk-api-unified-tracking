<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentReferenceInterface;

class ShipmentReference implements ShipmentReferenceInterface
{
    public function __construct(
        private readonly string $type,
        private readonly string $number
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
