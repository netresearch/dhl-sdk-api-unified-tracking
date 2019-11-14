<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Fixture;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TrackResponse
{
    /**
     * Read response files and return them as json string
     *
     * @return array
     */
    public static function getSuccessFullTrackResponses(): array
    {
        $finder = new Finder();
        $finder->name('*.json')->in(__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'success');
        $result = [];
        /** @var SplFileInfo $file */
        foreach ($finder->files() as $file) {
            $result['TrackId: ' . str_replace('*.json', '', $file->getFilename())] = [
                'jsonResponse' => file_get_contents(
                    $file->getPathname()
                ),
            ];
        }

        return $result;
    }

    /**
     * Read response files and return them as json string
     *
     * @return array
     */
    public static function getNotFoundTrackResponse(): array
    {
        $finder = new Finder();
        $finder->name('*.json')->in(__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'error');
        $result = [];
        /** @var SplFileInfo $file */
        foreach ($finder->files() as $file) {
            $result[str_replace('*.json', '', $file->getFilename())] = [
                'jsonResponse' => file_get_contents(
                    $file->getPathname()
                ),
            ];
        }

        return $result;
    }
}
