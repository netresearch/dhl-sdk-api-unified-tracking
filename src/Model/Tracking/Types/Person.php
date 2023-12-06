<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Person
 *
 * Consignee.
 */
class Person
{
    private string $organizationName = '';

    private string $familyName = '';

    private string $givenName = '';

    private string $name = '';

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
