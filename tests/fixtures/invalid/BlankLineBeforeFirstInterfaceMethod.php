<?php

declare(strict_types=1);

namespace Invalid;

interface BlankLineBeforeFirstInterfaceMethod
{

    public function methodA(): void;

    public function methodB(): void;
}
