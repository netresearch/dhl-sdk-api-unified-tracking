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
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface PhysicalAttributesInterface
{
    /**
     * Unit of measurement for the weight
     *
     * @return string
     */
    public function getWeightUom(): string;

    /**
     * Unit of measurement for width, length and height
     *
     * @return string
     */
    public function getDimensionUom(): string;

    public function getWeight(): ?float;

    public function getWidth(): ?float;

    public function getHeight(): ?float;

    public function getLength(): ?float;

    public function getLoadingMeters(): ?float;
}
