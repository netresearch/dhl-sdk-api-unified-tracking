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
 */
interface PersonInterface
{
    public function getOrganization(): string;

    public function getFamilyName(): string;

    public function getGivenName(): string;

    public function getName(): string;
}
