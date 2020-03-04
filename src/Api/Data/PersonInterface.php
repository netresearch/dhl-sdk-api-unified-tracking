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
    public function getOrganization(): string;

    public function getFamilyName(): string;

    public function getGivenName(): string;

    public function getName(): string;
}
