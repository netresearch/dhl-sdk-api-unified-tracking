<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\PhysicalAttributesInterface;

class PhysicalAttributes implements PhysicalAttributesInterface
{
    public function __construct(
        private readonly ?float $weight = null,
        private readonly string $weightUom = '',
        private readonly string $dimensionUom = '',
        private readonly ?float $width = null,
        private readonly ?float $height = null,
        private readonly ?float $length = null,
        private readonly ?float $loadingMeters = null
    ) {
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function getWeightUom(): string
    {
        return $this->weightUom;
    }

    public function getDimensionUom(): string
    {
        return $this->dimensionUom;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function getLoadingMeters(): ?float
    {
        return $this->loadingMeters;
    }
}
