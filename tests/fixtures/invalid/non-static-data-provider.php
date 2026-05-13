<?php

declare(strict_types=1);

namespace Invalid;

use PHPUnit\Framework\TestCase;

final class NonStaticDataProviderTest extends TestCase
{
    /**
     * @dataProvider provideValues
     */
    public function testSomething(int $value): void
    {
        self::assertSame($value, $value);
    }

    /**
     * @return iterable<array{int}>
     */
    public function provideValues(): iterable
    {
        yield [1];
    }
}
