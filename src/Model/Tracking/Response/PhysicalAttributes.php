<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\PhysicalAttributesInterface;

class PhysicalAttributes implements PhysicalAttributesInterface
{
    /**
     * @var float|null
     */
    private $weight;

    /**
     * @var string
     */
    private $weightUom;

    /**
     * @var string
     */
    private $dimensionUom;

    /**
     * @var float|null
     */
    private $width;

    /**
     * @var float|null
     */
    private $height;

    /**
     * @var float|null
     */
    private $length;

    /**
     * @var float|null
     */
    private $loadingMeters;

    /**
     * PhysicalAttributes constructor.
     *
     * @param float|null $weight
     * @param string $weightUom
     * @param string $dimensionUom
     * @param float|null $width
     * @param float|null $height
     * @param float|null $length
     * @param float|null $loadingMeters
     */
    public function __construct(
        float $weight = null,
        string $weightUom = '',
        string $dimensionUom = '',
        float $width = null,
        float $height = null,
        float $length = null,
        float $loadingMeters = null
    ) {
        $this->weight = $weight;
        $this->weightUom = $weightUom;
        $this->dimensionUom = $dimensionUom;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->loadingMeters = $loadingMeters;
    }

    public function getWeight()
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

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getLoadingMeters()
    {
        return $this->loadingMeters;
    }
}
