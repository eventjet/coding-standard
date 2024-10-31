<?php

declare(strict_types=1);

namespace Test;

class PrivateConstNowdoc
{
    private const MY_NOWDOC = <<<'NOWDOC'
        indented!
        NOWDOC;
}
