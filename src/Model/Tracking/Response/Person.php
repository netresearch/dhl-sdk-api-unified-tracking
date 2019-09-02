<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Response;

use Dhl\Sdk\Group\Tracking\Api\Data\PersonInterface;

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
