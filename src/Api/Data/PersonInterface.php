<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Api\Data;

/**
 * Interface PersonInterface
 *
 * Describing detailed information on a person
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link http://www.netresearch.de/
 */
interface PersonInterface
{

    /**
     * @return string
     */
    public function getOrganization(): string;

    /**
     * @return string
     */
    public function getFamilyName(): string;

    /**
     * @return string
     */
    public function getGivenName(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
