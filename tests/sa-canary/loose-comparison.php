<?php

declare(strict_types=1);

// Canary for the SA-overlap CI gate. Both PHPStan and Psalm MUST flag this
// file. If they don't, the CI script's "drop lint-territory fixtures" gate is
// silently broken — the SA configs are too lax, the JSON schema changed, or
// jq parsing went wrong. The gate script asserts this file is in the
// intersection of flagged files; an empty or wrong intersection fails CI.

$foo = 'foo' == 'bar';
