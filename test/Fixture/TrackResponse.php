<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Group\Tracking\Test\Fixture;

class TrackResponse
{
    public static function getSuccessFullTrackResponse(): string
    {
        return file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'successful_track.json'
        );
    }
}
