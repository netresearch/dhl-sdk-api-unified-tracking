<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Service;

use Dhl\Sdk\Group\Tracking\Api\Data\TrackResponseInterface;
use Dhl\Sdk\Group\Tracking\Api\TrackingServiceInterface;
use Dhl\Sdk\Group\Tracking\Model\ResponseMapper;
use Dhl\Sdk\Group\Tracking\Serializer\JsonSerializer;
use Exception;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Exception\HttpException;
use Http\Message\RequestFactory;
use Psr\Http\Client\ClientInterface;

class TrackingService implements TrackingServiceInterface
{
    /**
     * @var ClientInterface
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
     * @param ClientInterface $client
     * @param RequestFactory $requestFactory
     * @param JsonSerializer $serializer
     * @param ResponseMapper $responseMapper
     */
    public function __construct(
        ClientInterface $client,
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
        } catch (ClientErrorException $exception) {
            // @TODO handle exception
            throw $exception;
        } catch (HttpException $exception) {
            // @TODO handle exception
            throw $exception;
        } catch (Exception $exception) {
            // @TODO handle exception
            throw $exception;
        }

        return $this->responseMapper->map($responseObject);
    }
}
