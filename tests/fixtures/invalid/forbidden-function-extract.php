<?php

declare(strict_types=1);

namespace Invalid;

use function extract;

$data = ['foo' => 'bar'];
extract($data);
