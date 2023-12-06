<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\AddressInterface;

class Address implements AddressInterface
{
    public function __construct(
        private readonly string $countryCode = '',
        private readonly string $postalCode = '',
        private readonly string $addressLocality = '',
        private readonly string $streetAddress = ''
    ) {
    }

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
