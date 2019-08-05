<?php declare(strict_types=1);

namespace Eventjet;

use const E_USER_DEPRECATED;
use function trigger_error;

trigger_error('Test', E_USER_DEPRECATED);
