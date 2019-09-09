<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

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

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
