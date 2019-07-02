<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\_helpers;

use DateTime;
use DateTimeInterface;
use Werkspot\Enum\AbstractEnum;

trait AssertionTrait
{
    public static function assertDateTimeOrNull(?string $data, ?DateTimeInterface $actual): void
    {
        if ($data !== null) {
            self::assertSame($data, $actual->format(DateTime::ATOM));
        } else {
            self::assertNull($actual);
        }
    }

    public static function assertStringOrNull(?string $data, ?string $actual): void
    {
        if ($data !== null) {
            self::assertSame($data, $actual);
        } else {
            self::assertNull($actual);
        }
    }

    public static function assertEnumOrNull(?string $expected, string $class, ?AbstractEnum $actual)
    {
        if ($expected === null) {
            self::assertNull($actual);
        } else {
            self::assertInstanceOf($class, $actual);
            self::assertSame($expected, $actual->getValue());
        }
    }
}
