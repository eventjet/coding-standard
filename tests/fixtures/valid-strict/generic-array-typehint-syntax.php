<?php

declare(strict_types=1);

/**
 * @param array<array-key, string> $items
 */
function foo(array $items): void
{
    foreach ($items as $item) {
        echo $item;
    }
}
