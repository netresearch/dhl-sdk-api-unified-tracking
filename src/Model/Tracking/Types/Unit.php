<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class Unit
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $unitText = '';

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnitText(): string
    {
        return $this->unitText;
    }
}
