<?php

declare(strict_types=1);

function logicalOperatorAndCheck(bool $a, bool $b): void
{
    if ($a and $b) {
        echo 'yes';
    }
}
