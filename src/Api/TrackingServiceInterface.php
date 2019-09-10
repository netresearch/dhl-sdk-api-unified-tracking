<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;

/**
 * Interface TrackingServiceInterface
 *
 * Service which is able to fetch data from the unified tracking API
 *
 * @author Paul Siedler <paul.siedler@netresearch.de>
 * @link https://www.netresearch.de/
 */
interface TrackingServiceInterface
{
    const RESOURCE = 'https://api-eu.dhl.com/track/shipments';

    const SERVICE_FREIGHT = 'freight';
    const SERVICE_EXPRESS = 'express';
    const SERVICE_PARCEL_DE = 'parcel-de';
    const SERVICE_PARCEL_NL = 'parcel-nl';
    const SERVICE_PARCEL_PL = 'parcel-pl';
    const SERVICE_DSC = 'dsc';
    const SERVICE_DGF = 'dgf';
    const SERVICE_ECOMMERCE = 'ecommerce';

    /**
     * Fetches shipment information to given tracking number across all of DHL business units
     *
     * Additional parameters provided result in a better match for the result
     *
     * @param string $trackingNumber
     * @param string|null $service The DHL shipping service, one of: freight, express, parcel-de, parcel-nl, parcel-pl,
     *     dsc, dgf, ecommerce
     * @param string|null $requesterCountryCode Optional ISO 3166-1 alpha-2 country code represents country of the
     *     consumer of the API response. It optimizes the return of the API response.
     * @param string|null $originCountryCode Optional ISO 3166-1 alpha-2 country code of the shipment origin to further
     *     qualify the shipment tracking number (trackingNumber) parameter of the request. This parameter is necessary
     *     to search for the shipment in dsc service.
     * @param string|null $recipientPostalCode Postal code of the destination address to
     *
     * further qualify the shipment tracking number (trackingNumber) parameter of the request or
     * parcel-nl and parcel-de services to display full set of data in the response.
     * @param string $language ISO 639-1 2-character language code for the response.
     * This parameter serves as an indication of the client preferences ONLY. Language availability depends on the
     *     service used. The actual response language is indicated by the Content-Language header.
     * @return TrackResponseInterface[] in the form of [trackingNumber-sequenceNumber => TrackResponseInterface]
     * @throws ServiceException
     */
    public function retrieveTrackingInformation(
        string $trackingNumber,
        string $service = null,
        string $requesterCountryCode = null,
        string $originCountryCode = null,
        string $recipientPostalCode = null,
        string $language = 'en'
    ): array;
}
