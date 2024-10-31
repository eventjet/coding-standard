<?php

declare(strict_types=1);

namespace Test;

class PrivateConstHeredoc
{
    private const MY_NOWDOC = <<<HEREDOC
        indented!
        HEREDOC;
}
