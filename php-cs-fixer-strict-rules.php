<?php

declare(strict_types=1);

$basicRules = include __DIR__ . '/php-cs-fixer-rules.php';

return array_merge($basicRules, [
    'nullable_type_declaration' => [
        'syntax' => 'union',
    ],
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'case',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property',
            'property_static',
            'construct',
            'destruct',
            'method_public_static',
            'method_public_abstract_static',
            'method_protected_static',
            'method_protected_abstract_static',
            'method_private_static',
            'method_private_abstract_static',
            'magic',
            'method_public',
            'method_public_abstract',
            'phpunit',
            'method_protected_abstract',
            'method_protected',
            'method_private',
            'method_private_abstract',
        ],
    ],
    'self_accessor' => true,
    'static_lambda' => true,
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arguments',
            'arrays',
            'match',
            'parameters',
        ],
    ],
]);
