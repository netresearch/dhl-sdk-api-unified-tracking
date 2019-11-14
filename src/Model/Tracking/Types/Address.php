<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Types;

/**
 * Class Address
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
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

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getAddressLocality(): string
    {
        return $this->addressLocality;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }
}
