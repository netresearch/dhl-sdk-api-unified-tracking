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
    public static function getSuccessFullTrackResponses(): array
    {
        $finder = new Finder();
        $finder->name('*.json')->in(__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'success');
        $result = [];
        /** @var SplFileInfo $file */
        foreach ($finder->files() as $file) {
            $result['TrackId: ' . $file->getFilenameWithoutExtension()] = [
                'jsonResponse' => file_get_contents(
                    $file->getPathname()
                ),
            ];
        }

        return $result;
    }

    public static function getNotFoundTrackResponse(): array
    {
        $finder = new Finder();
        $finder->name('*.json')->in(__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'error');
        $result = [];
        /** @var SplFileInfo $file */
        foreach ($finder->files() as $file) {
            $result[$file->getFilenameWithoutExtension()] = ['jsonResponse' => file_get_contents($file->getPathname())];
        }

        return $result;
    }
}
