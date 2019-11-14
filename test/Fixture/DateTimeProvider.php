<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Fixture;

class DateTimeProvider
{
    /**
     * Returns a list of date/time string with valid time zone designators.
     *
     * @link https://en.wikipedia.org/wiki/ISO_8601#Time_zone_designators
     *
     * @return string[]
     */
    public static function withTimeZone(): array
    {
        return [
            'Date/Time/Timezone UTC in Zulu format (long) 1' => ['2019-06-01T10:00:00.55Z'],
            'Date/Time/Timezone UTC in Zulu format (long) 2' => ['2019-06-01T10:00:00Z'],
            'Date/Time/Timezone UTC in Zulu format (short)' => ['20190601T100000Z'],

            'Date/Time/Timezone UTC (long) 1' => ['2019-06-01T10:00:00.55+00:00'],
            'Date/Time/Timezone UTC (long) 2' => ['2019-06-01T10:00:00+00:00'],
            'Date/Time/Timezone UTC (short)' => ['2019-06-01T10:00:00+0000'],
            'Date/Time/Timezone UTC (hours only)' => ['2019-06-01T10:00:00+00'],

            'Date/Time/Timezone UTC, space, (long)' => ['2019-06-01 10:00:00+00:00'],
            'Date/Time/Timezone UTC, space, (short)' => ['2019-06-01 10:00:00+0000'],
            'Date/Time/Timezone UTC, space, (hours only)' => ['2019-06-01 10:00:00+00'],

            'Date/Time/Timezone Offset (long)' => ['2019-06-01T10:00:00+12:00'],
            'Date/Time/Timezone Offset (short)' => ['2019-06-01T10:00:00+1200'],
            'Date/Time/Timezone Offset (hours only)' => ['2019-06-01T10:00:00+12'],
            'Date/Time/Timezone Offset with milliseconds' => ['2019-06-01T10:00:00.55+12:00'],

            'Date/Time/Timezone Negative Offset (long)' => ['2019-06-01T10:00:00-12:00'],
            'Date/Time/Timezone Negative Offset (short)' => ['2019-06-01T10:00:00-1200'],
            'Date/Time/Timezone Negative Offset (hours only)' => ['2019-06-01T10:00:00-12'],
        ];
    }

    /**
     * Returns a list of date/time string with no/invalid time zone designators.
     *
     * @link https://en.wikipedia.org/wiki/ISO_8601#Time_zone_designators
     *
     * @return string[]
     */
    public static function noTimeZone(): array
    {
        return [
            // Invalid time zones according ISO-8601, but will be treated correctly as +00:00 by \DateTime
            //'Time zone -00:00 (long)' => ['2019-06-01T10:00:00-00:00'],
            //'Time zone -00:00 (short)' => ['2019-06-01T10:00:00-0000'],
            //'Time zone -00:00 (hours only)' => ['2019-06-01T10:00:00-00'],
            'xxx' => ['+12:00'],

            // No time zone, but valid ISO-8601 dates
            'Date only (short)' => ['20190601'],
            'Date only (long)' => ['2019-06-01'],
            'Date/Time (short)' => ['201906011000'],
            'Date/Time (long) 1' => ['2019-06-01T10:00'],
            'Date/Time (long) 2' => ['2019-06-01 10:00'],
            'Date/Time (long) 3' => ['2019-06-01 10:00:00'],
            'Date/Time (long) 4' => ['2019-06-01T10:00.55'],
            'Year only' => ['2019'],
            'Day 123 of year 2019 (short)' => ['2019123'],
            'Day 123 of year 2019 (long)' => ['2019-123'],
            'Year/Month' => ['2019-06'],
            'Year/Week/Day' => ['2019-W01-1'],
            'Year/Week/Day (long)' => ['2019-W51-1'],
            'Year/Week/Day (short) 1' => ['2019-W511'],
            'Year/Week/Day (short) 2' => ['2019W511'],
            'Year/Week (long)' => ['2019-W33'],
            'Year/Week (short)' => ['2019W33'],
        ];
    }
}
