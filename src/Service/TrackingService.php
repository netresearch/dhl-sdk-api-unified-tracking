<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Service;

use Dhl\Sdk\UnifiedTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationErrorException;
use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedErrorException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedServiceException;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceException;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceExceptionFactory;
use Dhl\Sdk\UnifiedTracking\Model\ResponseMapper;
use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class TrackingService implements TrackingServiceInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var JsonSerializer
     */
    private $serializer;

    /**
     * @var ResponseMapper
     */
    private $responseMapper;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        JsonSerializer $serializer,
        ResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->serializer = $serializer;
        $this->responseMapper = $responseMapper;
    }

    /**
     * @param string $trackingNumber
     * @param string|null $service
     * @param string|null $requesterCountryCode
     * @param string|null $originCountryCode
     * @param string|null $recipientPostalCode
     * @param string $language
     * @return TrackResponseInterface[]
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
    ): array {
        $requestParams = array_filter(
            [
                'trackingNumber' => $trackingNumber,
                'service' => $service,
                'requesterCountryCode' => $requesterCountryCode,
                'originCountryCode' => $originCountryCode,
                'recipientPostalCode' => $recipientPostalCode,
                'language' => $language,
            ]
        );

        $uri = sprintf('%s?%s', self::RESOURCE, http_build_query($requestParams));

        try {
            $request = $this->requestFactory->createRequest('GET', $uri);
            $response = $this->client->sendRequest($request);
            $responseJson = (string) $response->getBody();
            $responseObject = $this->serializer->decode($responseJson);
            $mappedResponse = $this->responseMapper->map($responseObject);
        } catch (AuthenticationErrorException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (ClientExceptionInterface $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        return $mappedResponse;
    }
}
