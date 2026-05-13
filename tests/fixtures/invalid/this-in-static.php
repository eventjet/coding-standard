<?php

declare(strict_types=1);

namespace Invalid;

class ThisInStatic
{
    public static function foo(): void
    {
        echo $this->bar;
    }
}
