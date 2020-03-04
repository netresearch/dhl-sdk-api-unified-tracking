<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Reference
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Reference
{
    /**
     * @var string
     */
    private $number = '';

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
     *
     * @var string
     */
    private $type = '';

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
