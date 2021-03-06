<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\ShipmentReferenceInterface;

class ShipmentReference implements ShipmentReferenceInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $number;

    public function __construct(string $type, string $number)
    {
        $this->type = $type;
        $this->number = $number;
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
