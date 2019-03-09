<?php

$rules = [
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'no_multiline_whitespace_before_semicolons' => true,
    'no_whitespace_in_blank_line' => true,
    'method_separation' => true,
    'single_blank_line_before_namespace' => true,
    'no_empty_statement' => true,
    'no_short_echo_tag' => true,
    'no_unused_imports' => true,
    'ordered_imports' => true,
    'ordered_class_elements' => ['use_trait', 'constant_public', 'constant_protected', 'constant_private', 'property_public', 'property_protected', 'property_private', 'construct', 'destruct', 'magic'],
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_indent' => true,
    'phpdoc_no_package' => true,
    'phpdoc_order' => true,
    'phpdoc_separation' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_trim' => true,
    'phpdoc_var_without_name' => true,
    'phpdoc_to_comment' => true,
    'single_quote' => true,
    'ternary_operator_spaces' => true,
    'trim_array_spaces' => true,
    'concat_space' => ['spacing' => 'one'],
];

$excludes = [
    'vendor',
    'storage',
    'node_modules',
];

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
            ->notName('_ide_helper.php')
    );