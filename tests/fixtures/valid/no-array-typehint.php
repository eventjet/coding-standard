<?php

declare(strict_types=1);

function foo(array $items): void
{
    foreach ($items as $item) {
        echo $item;
    }
}
