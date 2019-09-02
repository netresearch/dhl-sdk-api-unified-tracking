<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking\Response;

use Dhl\Sdk\GroupTracking\Api\Data\ShipmentReferenceInterface;

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

    /**
     * ShipmentReference constructor.
     *
     * @param string $type
     * @param string $number
     */
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
