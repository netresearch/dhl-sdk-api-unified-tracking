<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking\Types;

class Place
{
    /**
     * @var Address
     */
    private $address;

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }
}
