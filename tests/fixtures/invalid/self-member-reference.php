<?php

declare(strict_types=1);

namespace Invalid;

class SelfMemberReference
{
    public static function foo(): int
    {
        return SelfMemberReference::bar();
    }

    public static function bar(): int
    {
        return 1;
    }
}
