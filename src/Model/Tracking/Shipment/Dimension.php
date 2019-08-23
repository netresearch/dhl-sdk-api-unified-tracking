<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

/**
 * Class Dimension
 *
 * Total dimensions of the shipment
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Dimension
{
    /**
     * @var Unit
     */
    public $width;

    /**
     * @var Unit
     */
    public $height;

    /**
     * @var Unit
     */
    public $length;
}
