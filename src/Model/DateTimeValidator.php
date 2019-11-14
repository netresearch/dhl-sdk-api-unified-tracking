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
 *
 * @author Rico Sonntag <rico.sonntag@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class DateTimeValidator
{
    /**
     * Returns true if the given ISO-8601 time string contains a time zone offset. It does not validate
     * whether the time zone offset is valid according ISO-8601 (e.g. -00:00 is in valid).
     *
     * @param string $time
     *
     * @return bool
     */
    public function hasTimeZone(string $time): bool
    {
        return (preg_match('/^'
                // Date capturing group
                . '('
                . '(?:[0-9]{4})'               // Year (YYYY)
                . '-?'                         // Optional hyphen
                . '(?:1[0-2]|0[1-9])'          // Month (MM)
                . '-?'                         // Optional hyphen
                . '(?:3[01]|0[1-9]|[12][0-9])' // Day
                . ')'

                // Date/Time separator
                . '(?:\s|T)'

                // Time capturing group
                . '('
                . '(?:2[0-3]|[01][0-9])'  // Hours
                . ':?'                    // Optional colon
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

                . '$/', $time) !== 0);
    }
}
