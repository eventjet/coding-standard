<?php

/**
 * File Level Docblock
 */

declare(strict_types=1);

namespace Eventjet;

use stdClass;

use function trigger_error;

use const E_USER_DEPRECATED;

$obj = new stdClass();
trigger_error('Test ' . $obj::class, E_USER_DEPRECATED);
