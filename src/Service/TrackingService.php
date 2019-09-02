<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\GroupTracking\Service;

use Dhl\Sdk\GroupTracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\GroupTracking\Api\TrackingServiceInterface;
use Dhl\Sdk\GroupTracking\Exception\ClientException;
use Dhl\Sdk\GroupTracking\Exception\ServerException;
use Dhl\Sdk\GroupTracking\Exception\ServiceException;
use Dhl\Sdk\GroupTracking\Model\ResponseMapper;
use Dhl\Sdk\GroupTracking\Serializer\JsonSerializer;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\Exception\ServerErrorException;
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

    /**
     * @param string $trackingNumber
     * @param string|null $service
     * @param string|null $requesterCountryCode
     * @param string|null $originCountryCode
     * @param string|null $recipientPostalCode
     * @param string $language
     * @return TrackResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws ServiceException
     */
    public function retrieveTrackingInformation(
        string $trackingNumber,
        string $service = null,
        string $requesterCountryCode = null,
        string $originCountryCode = null,
        string $recipientPostalCode = null,
        string $language = 'en'
    ): TrackResponseInterface {

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
        } catch (\JsonMapper_Exception $exception) {
            throw ClientException::create($exception);
        } catch (ClientErrorException $exception) {
            throw ClientException::create($exception);
        } catch (ServerErrorException $exception) {
            throw ServerException::create($exception);
        }

        return $this->responseMapper->map($responseObject);
    }
}
