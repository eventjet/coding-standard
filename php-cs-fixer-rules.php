<?php

declare(strict_types=1);

return [
    '@PSR12' => true,
    'binary_operator_spaces' => true,
    'cast_spaces' => [
        'space' => 'none',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
        ],
    ],
    'function_declaration' => [
        'closure_fn_spacing' => 'none',
    ],
    'function_typehint_space' => true,
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
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
    'nullable_type_declaration_for_default_null_value' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'phpdoc_trim' => true,
    'php_unit_data_provider_static' => true,
    'single_space_after_construct' => true,
    'strict_comparison' => true,
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arrays',
        ],
    ],
];
