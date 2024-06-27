<?php

declare(strict_types=1);

return [
    '@PSR12' => true,
    'array_indentation' => true,
    'array_syntax' => true,
    'binary_operator_spaces' => true,
    'cast_spaces' => [
        'space' => 'none',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
        ],
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
    'declare_strict_types' => true,
    'fully_qualified_strict_types' => true,
    'function_declaration' => [
        'closure_fn_spacing' => 'none',
    ],
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
    'native_constant_invocation' => [
        'scope' => 'namespaced',
        'strict' => true,
    ],
    'native_function_invocation' => [
        'include' => ['@all'],
        'scope' => 'namespaced',
        'strict' => true,
    ],
    'new_with_parentheses' => [
        'named_class' => true,
        'anonymous_class' => false,
    ],
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_comment' => true,
    'no_empty_phpdoc' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'continue',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'throw',
            'use',
        ],
    ],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_superfluous_elseif' => true,
    'no_superfluous_phpdoc_tags' => [
        // Psalm wants us to have an explicit type annotation whenever we assign `mixed` to a variable.
        'allow_mixed' => true,
    ],
    'no_trailing_comma_in_singleline' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'phpdoc_trim' => true,
    'php_unit_data_provider_static' => true,
    'single_space_around_construct' => true,
    'strict_comparison' => true,
    'trailing_comma_in_multiline' => [
        'elements' => [
            'arrays',
        ],
    ],
    'trim_array_spaces' => true,
    'type_declaration_spaces' => true,
    'types_spaces' => [
        'space' => 'none',
    ],
    'whitespace_after_comma_in_array' => [
        'ensure_single_space' => true,
    ],
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
];
