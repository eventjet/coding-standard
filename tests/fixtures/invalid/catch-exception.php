<?php

declare(strict_types=1);

namespace Invalid;

use Exception;

try {
    throw new Exception('boom');
} catch (Exception $e) {
    echo $e->getMessage();
}
