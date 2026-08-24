<?php

declare(strict_types=1);

namespace Invalid;

use function settype;

$value = '1';
settype($value, 'integer');
