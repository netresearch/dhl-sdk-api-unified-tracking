<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Place
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
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
