<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Serializer;

use Dhl\Sdk\UnifiedTracking\Model\Tracking\Types\TrackingResponseType;

class JsonSerializer
{
    /**
     * JsonSerializer constructor.
     *
     * @param string[] $classMap
     */
    public function __construct(private readonly array $classMap = [])
    {
    }

    /**
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function decode(string $jsonResponse): TrackingResponseType
    {
        $jsonMapper = new \JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;
        $jsonMapper->classMap = $this->classMap;

        $response = \json_decode($jsonResponse, false, 512, JSON_THROW_ON_ERROR);

        /** @var TrackingResponseType $mappedResponse */
        $mappedResponse = $jsonMapper->map($response, new TrackingResponseType());

        return $mappedResponse;
    }
}
