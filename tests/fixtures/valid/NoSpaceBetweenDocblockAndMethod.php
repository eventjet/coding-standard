<?php

declare(strict_types=1);

namespace Valid;

interface NoSpaceBetweenDocblockAndMethod
{
    public function methodA(): void;

    /**
     * This does something
     */
    public function methodB(): void;
}
