<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Model;

use Dhl\Sdk\UnifiedTracking\Model\DateTimeValidator;
use PHPUnit\Framework\TestCase;

class DateTimeValidatorTest extends TestCase
{
    /**
     * @var DateTimeValidator
     */
    private $dateTimeValidator;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dateTimeValidator = new DateTimeValidator();
    }

    /**
     * @test
     *
     * @dataProvider \Dhl\Sdk\UnifiedTracking\Test\Fixture\DateTimeProvider::withTimeZone
     * @param string $time
     */
    public function hasTimeZone(string $time)
    {
        self::assertTrue($this->dateTimeValidator->hasTimeZone($time));
    }

    /**
     * @test
     *
     * @dataProvider \Dhl\Sdk\UnifiedTracking\Test\Fixture\DateTimeProvider::noTimeZone
     * @param string $time
     */
    public function hasNoTimeZone(string $time)
    {
        self::assertFalse($this->dateTimeValidator->hasTimeZone($time));
    }
}
