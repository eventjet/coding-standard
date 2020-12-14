<?php

declare(strict_types=1);

namespace Invalid;

interface NoEmptyLineBetweenInterfaceMethods
{
    public function methodA(): void;
    public function methodB(): void;
}
