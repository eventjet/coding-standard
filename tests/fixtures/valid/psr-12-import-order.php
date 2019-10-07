<?php

/**
 * File Level Docblock
 */

declare(strict_types=1);

namespace Eventjet;

use stdClass;

use function trigger_error;

use const E_USER_DEPRECATED;

new stdClass();
trigger_error('Test', E_USER_DEPRECATED);
