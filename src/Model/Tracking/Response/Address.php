<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model\Tracking\Response;

use Dhl\Sdk\UnifiedTracking\Api\Data\AddressInterface;

class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $addressLocality;

    /**
     * @var string
     */
    private $streetAddress;

    /**
     * Address constructor.
     *
     * @param string $countryCode
     * @param string $postalCode
     * @param string $addressLocality
     * @param string $streetAddress
     */
    public function __construct(
        string $countryCode = '',
        string $postalCode = '',
        string $addressLocality = '',
        string $streetAddress = ''
    ) {
        $this->countryCode = $countryCode;
        $this->postalCode = $postalCode;
        $this->addressLocality = $addressLocality;
        $this->streetAddress = $streetAddress;
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
