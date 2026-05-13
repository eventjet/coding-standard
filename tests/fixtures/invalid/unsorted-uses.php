<?php

declare(strict_types=1);

namespace Invalid;

use RuntimeException;
use LogicException;

throw new LogicException('a');
throw new RuntimeException('b');
