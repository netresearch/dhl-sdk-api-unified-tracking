<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Model;

/**
 * Class DateTimeValidator
 *
 * Provides methods to validate a date/time string.
 */
class DateTimeValidator
{
    /**
     * Returns true if the given ISO-8601 time string contains a time zone offset. It does not validate
     * whether the time zone offset is valid according ISO-8601 (e.g. -00:00 is in valid).
     *
     * phpcs:disable Generic.Files.LineLength.TooLong
     */
    public function hasTimeZone(string $time): bool
    {
        return (
            preg_match(
                '/^((?:[0-9]{4})-?(?:1[0-2]|0[1-9])-?(?:3[01]|0[1-9]|[12][0-9]))(?:\s|T)((?:2[0-3]|[01][0-9]):?' // Optional colon
                . '(?:[0-5][0-9])'        // Minutes
                . ':?'                    // Optional colon
                . '(?:[0-5][0-9])'        // Seconds
                . '(?:\.[0-9]+)?'         // Optional fractional seconds
                . ')'

                // Time zone capturing group
                . '('
                . 'Z|[+-]'                // UTC identifier or +/-
                . '(?:2[0-3]|[01][0-9])'  // Hours
                . '(?::?(?:[0-5][0-9]))?' // Optional minutes
                . ')'

                . '$/',
                $time
            ) !== 0
        );
    }
}
