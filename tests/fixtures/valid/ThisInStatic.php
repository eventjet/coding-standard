<?php

declare(strict_types=1);

namespace ThisInStaticCanary;

// Dual-purpose fixture for the this-in-static rule drop:
//   - CS side: phpcs and php-cs-fixer must leave this alone (the rule is
//     disabled — see Eventjet/ruleset.xml).
//   - SA side: PHPStan and Psalm must both flag it — tests/check-sa-overlap.sh
//     enforces that, which is what justifies dropping the CS rule.

class ThisInStatic
{
    public static function foo(): void
    {
        echo $this->bar;
    }
}
