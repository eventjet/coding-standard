<?php

declare(strict_types=1);

namespace Eventjet;

final class NoArrayReturnTypeAnnotation implements NoArrayReturnTypeAnnotationInterface
{
    public function getBar(array $input): array
    {
        return [];
    }
}
