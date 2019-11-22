<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Service;

use Dhl\Sdk\UnifiedTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\UnifiedTracking\Exception\AuthenticationErrorException;
use Dhl\Sdk\UnifiedTracking\Exception\DetailedErrorException;
use Dhl\Sdk\UnifiedTracking\Exception\ServiceExceptionFactory;
use Dhl\Sdk\UnifiedTracking\Model\ResponseMapper;
use Dhl\Sdk\UnifiedTracking\Serializer\JsonSerializer;
use Http\Client\Exception as HttpClientException;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;

class TrackingService implements TrackingServiceInterface
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var RequestFactory
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

    /**
     * TrackingService constructor.
     *
     * @param HttpClient $client
     * @param RequestFactory $requestFactory
     * @param JsonSerializer $serializer
     * @param ResponseMapper $responseMapper
     */
    public function __construct(
        HttpClient $client,
        RequestFactory $requestFactory,
        JsonSerializer $serializer,
        ResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->serializer = $serializer;
        $this->responseMapper = $responseMapper;
    }

    public function retrieveTrackingInformation(
        string $trackingNumber,
        string $service = null,
        string $requesterCountryCode = null,
        string $originCountryCode = null,
        string $recipientPostalCode = null,
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
        } catch (HttpClientException $exception) {
            throw ServiceExceptionFactory::createServiceException($exception);
        } catch (\Throwable $exception) {
            throw ServiceExceptionFactory::create($exception);
        }

        return $mappedResponse;
    }
}
