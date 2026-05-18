<?php

declare(strict_types=1);

// The `if (cond) { return true; } return false;` shape is allowed — the rules
// that would collapse it (`SlevomatCodingStandard.ControlStructures.UselessIfConditionWithReturn`
// and `simplified_if_return`) are off. The pattern is useful in functions
// where several branches each return a boolean: collapsing only the last
// branch would make it visually inconsistent with the ones above it.
function canProceed(int $value, bool $locked): bool
{
    if ($locked) {
        return false;
    }
    if ($value < 0) {
        return false;
    }
    if ($value > 0) {
        return true;
    }
    return false;
}
