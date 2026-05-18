<?php

declare(strict_types=1);

function foo(int | string $value): int | string
{
    return $value;
}
