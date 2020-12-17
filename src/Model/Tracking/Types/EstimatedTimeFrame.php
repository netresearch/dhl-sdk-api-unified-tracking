<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class EstimatedTimeFrame
 *
 * Estimated Time Frame of Delivery
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

    public function getEstimatedFrom(): string
    {
        return $this->estimatedFrom;
    }

    public function getEstimatedThrough(): string
    {
        return $this->estimatedThrough;
    }
}
