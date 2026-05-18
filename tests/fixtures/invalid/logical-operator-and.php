<?php

declare(strict_types=1);

function logicalOperatorAndCheck(bool $a, bool $b): void
{
    if ($a AND $b) {
        echo 'yes';
    }
}
