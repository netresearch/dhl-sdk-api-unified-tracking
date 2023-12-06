<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Api;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedServiceException;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;

/**
 * Interface TrackingServiceInterface
 *
 * Service which is able to fetch data from the unified tracking API
 *
 * @api
 */
interface TrackingServiceInterface
{
    public const RESOURCE = 'https://api-eu.dhl.com/track/shipments';

    final public const SERVICE_FREIGHT = 'freight';
    final public const SERVICE_EXPRESS = 'express';
    final public const SERVICE_POST_DE = 'post-de';
    final public const SERVICE_PARCEL_DE = 'parcel-de';
    final public const SERVICE_PARCEL_NL = 'parcel-nl';
    final public const SERVICE_PARCEL_PL = 'parcel-pl';
    final public const SERVICE_DSC = 'dsc';
    final public const SERVICE_DGF = 'dgf';
    final public const SERVICE_ECOMMERCE = 'ecommerce';

    /**
     * Fetches shipment information to given tracking number across all of DHL business units
     *
     * Additional parameters provided result in a better match for the result
     *
     * @param string $trackingNumber The tracking number of the shipment for which to return the information.
     * @param string|null $service Hint which service (provider) should be used to resolve the tracking number.
     *                             Available values : freight, express, post-de, parcel-de, parcel-nl, parcel-pl,
     *                             dsc, dgf, ecommerce
     * @param string|null $requesterCountryCode Optional ISO 3166-1 alpha-2 country code represents country of the
     *                                          consumer of the API response. It optimizes the return of the
     *                                          API response.
     * @param string|null $originCountryCode Optional ISO 3166-1 alpha-2 country code of the shipment origin to further
     *                                       qualify the shipment tracking number (trackingNumber) parameter of
     *                                       the request. This parameter is necessary to search for the shipment
     *                                       in dsc service.
     * @param string|null $recipientPostalCode Postal code of the destination address to (a) further qualify the
     *                                         shipment tracking number parameter of the request or (b) display the
     *                                         full set of data in the response for parcel-nl and parcel-de services.
     * @param string $language ISO 639-1 2-character language code for the response. This parameter serves as an
     *                         indication of the client preferences ONLY. Language availability depends on the
     *                         service used. The actual response language is indicated by the Content-Language header.
     *
     * @return TrackResponseInterface[] in the form of [trackingNumber-sequenceNumber => TrackResponseInterface]
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws ServiceException
     */
    public function retrieveTrackingInformation(
        string $trackingNumber,
        ?string $service = null,
        ?string $requesterCountryCode = null,
        ?string $originCountryCode = null,
        ?string $recipientPostalCode = null,
        string $language = 'en'
    ): array;
}
