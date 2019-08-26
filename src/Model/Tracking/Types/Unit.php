<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

class Unit
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $unitText;

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getUnitText(): string
    {
        return $this->unitText;
    }
}
