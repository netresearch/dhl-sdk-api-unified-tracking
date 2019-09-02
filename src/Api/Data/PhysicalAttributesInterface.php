<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Api\Data;

/**
 * Interface PhysicalAttributesInterface
 *
 * Wrapping all physical package values
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link http://www.netresearch.de/
 */
interface PhysicalAttributesInterface
{

    /**
     * Package weight
     *
     * @return float
     */
    public function getWeight(): float;

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
