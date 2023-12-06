<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\UnifiedTracking\Test\Model;

use Dhl\Sdk\UnifiedTracking\Model\DateTimeValidator;
use Dhl\Sdk\UnifiedTracking\Test\Fixture\DateTimeProvider;
use PHPUnit\Framework\TestCase;

class DateTimeValidatorTest extends TestCase
{
    private DateTimeValidator $dateTimeValidator;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dateTimeValidator = new DateTimeValidator();
    }


    #[\PHPUnit\Framework\Attributes\DataProviderExternal(DateTimeProvider::class, 'withTimeZone')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function hasTimeZone(string $time): void
    {
        self::assertTrue($this->dateTimeValidator->hasTimeZone($time));
    }


    #[\PHPUnit\Framework\Attributes\DataProviderExternal(DateTimeProvider::class, 'noTimeZone')]
    #[\PHPUnit\Framework\Attributes\Test]
    public function hasNoTimeZone(string $time): void
    {
        self::assertFalse($this->dateTimeValidator->hasTimeZone($time));
    }
}
