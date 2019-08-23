<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Model\Tracking\Shipment;

class Address
{
    /**
     * @var string
     */
    public $countryCode;

    /**
     * @var string
     */
    public $postalCode;

    /**
     * @var string
     */
    public $addressLocality;

    /**
     * @var string
     */
    public $streetAddress;
}
