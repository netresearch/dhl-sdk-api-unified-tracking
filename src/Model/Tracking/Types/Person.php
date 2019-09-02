<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Types;

/**
 * Class Person
 *
 * Consignee.
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Person
{
    /**
     * @var string
     */
    private $organizationName = '';

    /**
     * @var string
     */
    private $familyName = '';

    /**
     * @var string
     */
    private $givenName = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @return string
     */
    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
