<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface PersonInterface
 *
 * Describing detailed information on a person
 *
 * @api
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
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
