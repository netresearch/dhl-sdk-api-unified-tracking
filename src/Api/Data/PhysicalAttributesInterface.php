<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface PhysicalAttributesInterface
 *
 * Wrapping all physical package values
 *
 * @api
 */
interface PhysicalAttributesInterface
{
    /**
     * Unit of measurement for the weight
     */
    public function getWeightUom(): string;

    /**
     * Unit of measurement for width, length and height
     */
    public function getDimensionUom(): string;

    public function getWeight(): ?float;

    public function getWidth(): ?float;

    public function getHeight(): ?float;

    public function getLength(): ?float;

    public function getLoadingMeters(): ?float;
}
