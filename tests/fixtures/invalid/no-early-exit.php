<?php

declare(strict_types=1);

function process(int $value): int
{
    if ($value > 0) {
        return $value * 2;
    } else {
        return 0;
    }
}
