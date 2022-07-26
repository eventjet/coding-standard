<?php

declare(strict_types=1);

namespace Eventjet;

interface NoArrayReturnTypeAnnotationInterface
{
    /**
     * @param list<string> $input
     * @return list<string>
     */
    public function getBar(array $input): array;
}
