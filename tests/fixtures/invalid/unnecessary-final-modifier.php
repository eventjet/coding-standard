<?php

declare(strict_types=1);

namespace Invalid;

final class UnnecessaryFinalModifier
{
    final public function foo(): void
    {
    }
}
