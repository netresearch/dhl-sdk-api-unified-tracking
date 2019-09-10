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
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface PhysicalAttributesInterface
{
    /**
     * Package weight
     *
     * @return float|null
     */
    public function getWeight();

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

    /**
     * Package width
     *
     * @return float|null
     */
    public function getWidth();

    /**
     * Package heigth
     *
     * @return float|null
     */
    public function getHeight();

    /**
     * Package length
     *
     * @return float|null
     */
    public function getLength();

    /**
     * @return float|null
     */
    public function getLoadingMeters();
}
