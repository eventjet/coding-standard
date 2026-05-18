<?php

declare(strict_types=1);

function isPositive(int $value): bool
{
    if ($value > 0) {
        return true;
    }
    return false;
}
