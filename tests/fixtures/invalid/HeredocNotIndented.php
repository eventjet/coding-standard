<?php

declare(strict_types=1);

namespace Test;

class HeredocNotIndented
{
    private const MY_NOWDOC = <<<HEREDOC
not indented!
HEREDOC;
}
