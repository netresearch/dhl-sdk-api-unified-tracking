<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Organization
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Organization
{
    /**
     * The name of the organization expressed in text.
     *
     * @var string
     */
    private $organizationName = '';

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }
}
