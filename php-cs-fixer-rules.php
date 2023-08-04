<?php

declare(strict_types=1);

return [
    '@PSR12' => true,
    'binary_operator_spaces' => true,
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
        ],
    ],
    'function_declaration' => [
        'closure_fn_spacing' => 'none',
    ],
    'function_typehint_space' => true,
    'new_with_braces' => [
        'named_class' => true,
        'anonymous_class' => false,
    ],
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_comment' => true,
    'no_empty_phpdoc' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'extra',
            'use',
        ],
    ],
    'no_unused_imports' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'phpdoc_trim' => true,
    'php_unit_data_provider_static' => true,
    'single_space_after_construct' => true,
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arrays',
        ],
    ],
];
