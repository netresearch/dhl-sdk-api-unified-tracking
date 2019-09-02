<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Response;

use Dhl\Sdk\Group\Tracking\Api\Data\DeliveryTimeFrameInterface;

class DeliveryTimeFrame implements DeliveryTimeFrameInterface
{
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * DeliveryTimeFrame constructor.
     *
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function __construct(\DateTime $start, \DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }
}
