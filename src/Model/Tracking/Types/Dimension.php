<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Dimension
 *
 * Total dimensions of the shipment
 */
class Dimension
{
    private ?Unit $width = null;

    private ?Unit $height = null;

    private ?Unit $length = null;

    public function getWidth(): ?Unit
    {
        return $this->width;
    }

    public function getHeight(): ?Unit
    {
        return $this->height;
    }

    public function getLength(): ?Unit
    {
        return $this->length;
    }
}
