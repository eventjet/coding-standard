<?php

declare(strict_types=1);

function generator(): iterable
{
    yield(1);
}

foreach (generator() as $value) {
    echo $value;
}
