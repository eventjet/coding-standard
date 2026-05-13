<?php

declare(strict_types=1);

// Dual-purpose fixture for the loose-comparison rule drop:
//   - CS side: phpcs and php-cs-fixer must leave this alone (the rules are
//     disabled — see Eventjet/ruleset.xml and php-cs-fixer-rules.php).
//   - SA side: PHPStan and Psalm must both flag it — tests/check-sa-overlap.sh
//     enforces that, which is what justifies dropping the CS rule.

$foo = 'foo' == 'bar';
