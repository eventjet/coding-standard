<?php

declare(strict_types=1);

$rules = include __DIR__ . '/../php-cs-fixer-rules.php';
assert(is_array($rules));

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setFinder(PhpCsFixer\Finder::create())
    ->setRiskyAllowed(true);
