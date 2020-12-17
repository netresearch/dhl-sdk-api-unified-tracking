<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

class Address
{
    /**
     * @var string
     */
    private $countryCode = '';

    /**
     * @var string
     */
    private $postalCode = '';

    /**
     * @var string
     */
    private $addressLocality = '';

    /**
     * @var string
     */
    private $streetAddress = '';

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getAddressLocality(): string
    {
        return $this->addressLocality;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }
}
