<?php

declare(strict_types=1);

/**
 * @param array<string, mixed> $struct
 */
function getFoo(array $struct): void
{
    /** @var mixed $foo */
    $foo = $struct['foo'];
    echo $foo;
}
