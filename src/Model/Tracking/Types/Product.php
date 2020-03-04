<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Product
 *
 * Product used for the shipment.
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
class Product
{
    /**
     * Consumer friendly short description of the product suitable for compact presentation.
     *
     * @var string
     */
    private $productName = '';

    public function getProductName(): string
    {
        return $this->productName;
    }
}
