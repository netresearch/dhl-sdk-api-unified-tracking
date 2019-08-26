<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Serializer;

use Dhl\Sdk\Group\Tracking\Model\Tracking\Types\TrackingResponseType;
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

    public function decode(string $jsonResponse): TrackingResponseType
    {
        $jsonMapper = new JsonMapper();
        $jsonMapper->bIgnoreVisibility = true;
        $jsonMapper->classMap = $this->classMap;

        $response = json_decode($jsonResponse);

        return $jsonMapper->map($response, new TrackingResponseType());
    }
}
