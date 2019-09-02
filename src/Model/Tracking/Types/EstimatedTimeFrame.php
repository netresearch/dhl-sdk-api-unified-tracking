<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Model\Tracking\Types;

/**
 * Class EstimatedTimeFrame
 *
 * Estimated Time Frame of Delivery
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class EstimatedTimeFrame
{
    /**
     * example: 2018-08-03T00:00:00Z
     * The start date of the estimated time frame, http://schema.org/DateTime
     *
     * @var string
     */
    private $estimatedFrom = '';

    /**
     * example: 2018-08-03T22:00:00Z
     * The end date of the estimated time frame,
     *
     * @var string
     */
    private $estimatedThrough = '';

    /**
     * @return string
     */
    public function getEstimatedFrom(): string
    {
        return $this->estimatedFrom;
    }

    /**
     * @return string
     */
    public function getEstimatedThrough(): string
    {
        return $this->estimatedThrough;
    }
}
