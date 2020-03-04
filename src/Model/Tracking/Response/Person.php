<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\PersonInterface;

class Person implements PersonInterface
{
    /**
     * @var string
     */
    private $organization;

    /**
     * @var string
     */
    private $familyName;

    /**
     * @var string
     */
    private $givenName;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $organization, string $familyName, string $givenName, string $name)
    {
        $this->organization = $organization;
        $this->familyName = $familyName;
        $this->givenName = $givenName;
        $this->name = $name;
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
