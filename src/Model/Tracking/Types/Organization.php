<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class Organization
{
    /**
     * The name of the organization expressed in text.
     */
    private string $organizationName = '';

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }
}
