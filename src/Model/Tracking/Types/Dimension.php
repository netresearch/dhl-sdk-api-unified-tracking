<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

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
    private $width;

    /**
     * @var Unit
     */
    private $height;

    /**
     * @var Unit
     */
    private $length;

    /**
     * @return Unit
     */
    public function getWidth(): Unit
    {
        return $this->width;
    }

    /**
     * @return Unit
     */
    public function getHeight(): Unit
    {
        return $this->height;
    }

    /**
     * @return Unit
     */
    public function getLength(): Unit
    {
        return $this->length;
    }
}
