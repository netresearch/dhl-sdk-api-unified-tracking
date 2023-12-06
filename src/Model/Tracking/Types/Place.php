<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class Place
{
    private ?Address $address = null;

    public function getAddress(): ?Address
    {
        return $this->address;
    }
}
