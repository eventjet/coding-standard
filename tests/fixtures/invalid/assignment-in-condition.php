<?php

declare(strict_types=1);

$bar = 0;
if (($foo = $bar) === 0) {
    echo $foo;
}
