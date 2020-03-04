<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Unit
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
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
