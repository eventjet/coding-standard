<?php

declare(strict_types=1);

function elseIfCheck(int $foo): void
{
    if ($foo === 1) {
        echo 'one';
    } else if ($foo === 2) {
        echo 'two';
    } else {
        echo 'other';
    }
}
