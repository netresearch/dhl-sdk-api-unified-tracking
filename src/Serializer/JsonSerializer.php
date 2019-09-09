<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Serializer;

use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\TrackingResponseType;
use JsonMapper;
use function json_decode;

class JsonSerializer
{

    /**
     * @var string[]
     */
    private $classMap;

    /**
     * JsonSerializer constructor.
     *
     * @param string[] $classMap
     */
    public function __construct(array $classMap = [])
    {
        $this->classMap = $classMap;
    }

    /**
     * @param string $jsonResponse
     * @return TrackingResponseType
     * @throws \JsonMapper_Exception
     */
    public function decode(string $jsonResponse): TrackingResponseType
    {
        $jsonMapper = new JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;
        $jsonMapper->classMap = $this->classMap;

        $response = json_decode($jsonResponse, false);

        /** @var TrackingResponseType $mappedResponse */
        $mappedResponse = $jsonMapper->map($response, new TrackingResponseType());

        return $mappedResponse;
    }
}
