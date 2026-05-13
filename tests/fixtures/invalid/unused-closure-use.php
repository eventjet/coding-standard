<?php

declare(strict_types=1);

$bar = 1;
$closure = function () use ($bar): int {
    return 1;
};
$closure();
