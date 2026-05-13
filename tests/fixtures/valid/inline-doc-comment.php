<?php

declare(strict_types=1);

// Dual-purpose canary for the InlineDocCommentDeclaration.InvalidFormat code:
//   - CS side: phpcs and php-cs-fixer must leave this alone. InvalidFormat is
//     excluded in Eventjet/ruleset.xml; php-cs-fixer's
//     `phpdoc_var_annotation_correct_order` is disabled in php-cs-fixer-rules.php
//     so it doesn't silently canonicalize the wrong order away.
//   - SA side: PHPStan and Psalm must both flag it — tests/check-sa-overlap.sh
//     enforces that, which is what justifies excluding the CS code.

/** @var $foo string */
$foo = 'bar';
echo $foo;
