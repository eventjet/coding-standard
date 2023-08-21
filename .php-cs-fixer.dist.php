<?php

declare(strict_types=1);

use Eventjet\CodingStandard\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()->in(__DIR__)->exclude('tests/fixtures');
return Config::basic($finder);
