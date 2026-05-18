<?php

declare(strict_types=1);

function check(int $value): int
{
    if ($value > 0) {
        return 1;
    } else {
        return 0;
    }
}
