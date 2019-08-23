<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Api;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;

interface TrackingServiceInterface
{
    const RESOURCE = 'https://api-eu.dhl.com/track/shipments';

    /**
     * Fetches shipment information to given tracking number across all of DHL business units
     *
     * Additional parameters provided result in a better match for the result
     *
     * @param string $trackingNumber
     * @param string|null $service
     * @param string|null $requesterCountryCode
     * @param string|null $originCountryCode
     * @param string|null $recipientPostalCode
     * @param string $language
     * @return mixed
     */
    public function retrieveTrackingInformation(
        string $trackingNumber,
        string $service = null,
        string $requesterCountryCode = null,
        string $originCountryCode = null,
        string $recipientPostalCode = null,
        string $language = 'en'
    ): TrackResponseInterface;
}
