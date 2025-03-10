<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api\Data;

/**
 * Interface AddressInterface
 *
 * Describes information on specific addresses
 *
 * @api
 */
interface AddressInterface
{
    /**
     * A short text string code (ISO 3166-1 alpha-2 country code) specifying the country.
     */
    public function getCountryCode(): string;

    /**
     * Text specifying the postal code for an address.
     */
    public function getPostalCode(): string;

    /**
     * Text specifying the name of the locality, for example a city.
     */
    public function getAddressLocality(): string;

    /**
     * The street address expressed as free form text. The street address is printed on paper as the first lines below
     * the name. For example, the name of the street and the number in the street or the name of a building
     */
    public function getStreetAddress(): string;
}
