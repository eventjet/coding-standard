<?php

declare(strict_types=1);

function foo(int $value): int
{
    if ($value > 0) {
        return 1;
    } elseif ($value < 0) {
        return -1;
    }
    return 0;
}
