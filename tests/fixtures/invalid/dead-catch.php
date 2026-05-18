<?php

declare(strict_types=1);

namespace Invalid;

use RuntimeException;
use Throwable;

try {
    throw new RuntimeException('boom');
} catch (Throwable $t) {
    echo $t->getMessage();
} catch (RuntimeException $e) {
    echo $e->getMessage();
}
