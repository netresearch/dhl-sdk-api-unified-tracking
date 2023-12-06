<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\PersonInterface;

class Person implements PersonInterface
{
    public function __construct(
        private readonly string $organization,
        private readonly string $familyName,
        private readonly string $givenName,
        private readonly string $name
    ) {
    }

    public function getOrganization(): string
    {
        return $this->organization;
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
