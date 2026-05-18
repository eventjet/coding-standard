<?php

declare(strict_types=1);

/** @return iterable<int, int> */
function generator(): iterable
{
    yield(1);
}

foreach (generator() as $value) {
    echo $value;
}
