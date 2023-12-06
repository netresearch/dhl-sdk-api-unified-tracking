<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class Reference
{
    private string $number = '';

    /**
     * One of:
     * - customer-reference
     * - customer-confirmation-number
     * - local-tracking-number
     * - ecommerce-number
     * - housebill
     * - masterbill
     * - container-number
     * - domestic-consignment-id
     */
    private string $type = '';

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
