<?php

declare(strict_types=1);

function yodaComparisonCheck(string $foo): void
{
    if ('bar' === $foo) {
        echo $foo;
    }
}
