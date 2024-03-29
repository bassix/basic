<?php

declare(strict_types=1);

/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:2.16.7|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();
$config
  ->setRiskyAllowed(true)
  ->setIndent('  ')
  ->setRules([
    '@PSR2' => true,
    // Each line of multi-line DocComments must have an asterisk [PSR-5] and must be aligned with the first one.
    'align_multiline_comment' => true,
    // Each element of an array must be indented exactly once.
    'array_indentation' => true,
    // PHP arrays should be declared using the configured syntax.
    'array_syntax' => ['syntax' => 'short'],
    // Binary operators should be surrounded by space as configured.
    'binary_operator_spaces' => [
      'operators' => [
        '=' => 'single_space',
        'xor' => null,
        '+=' => 'single_space',
        '===' => 'single_space',
        '|' => 'no_space',
        '=>' => 'align_single_space_minimal',
      ],
    ],
    // There MUST be one blank line after the namespace declaration.
    'blank_line_after_namespace' => true,
    // An empty line feed must precede any configured statement.
    'blank_line_before_statement' => true,
    // The body of each structure MUST be enclosed by braces. Braces should be properly placed. Body of braces should be properly indented.
    'braces' => ['allow_single_line_closure' => true],
    // Class, trait and interface elements must be separated with one blank line.
    'class_attributes_separation' => false,
    // Whitespace around the keywords of a class, trait or interfaces definition should be one space.
    'class_definition' => true,
    // Using `isset($var) &&` multiple times should be done in one call.
    'combine_consecutive_issets' => true,
    // Calling `unset` on multiple items should be done in one call.
    'combine_consecutive_unsets' => true,
    // Remove extra spaces in a nullable typehint.
    'compact_nullable_typehint' => true,
    // Concatenation should be spaced according configuration.
    'concat_space' => ['spacing' => 'one'],
    // Equal sign in declare statement should be surrounded by spaces or not following configuration.
    'declare_equal_normalize' => true,
    // Force strict types declaration in all files. Requires PHP >= 7.0.
    'declare_strict_types' => true,
    // Doctrine annotations must use configured operator for assignment in arrays.
    'doctrine_annotation_array_assignment' => true,
    // Doctrine annotations without arguments must use the configured syntax.
    'doctrine_annotation_braces' => true,
    // Doctrine annotations must be indented with four spaces.
    'doctrine_annotation_indentation' => true,
    // Fixes spaces in Doctrine annotations.
    'doctrine_annotation_spaces' => true,
    // The keyword `elseif` should be used instead of `else if` so that all control keywords look like single words.
    'elseif' => true,
    // PHP code MUST use only UTF-8 without BOM (remove BOM).
    'encoding' => true,
    // PHP code must use the long `<?php` tags or short-echo `<?=` tags and not other tag variations.
    'full_opening_tag' => true,
    // Spaces should be properly placed in a function declaration.
    'function_declaration' => true,
    // Ensure single space between function's argument and its typehint.
    'function_typehint_space' => true,
    // Configured annotations should be omitted from PHPDoc.
    'general_phpdoc_annotation_remove' => true,
    // Code MUST use configured indentation type.
    'indentation_type' => true,
    // Replaces `is_null($var)` expression with `null === $var`.
    'is_null' => true,
    // Ensure there is no code on the same line as the PHP open tag.
    'linebreak_after_opening_tag' => true,
    // Use `&&` and `||` logical operators instead of `and` and `or`.
    'logical_operators' => true,
    // Cast should be written in lower case.
    'lowercase_cast' => true,
    // The PHP constants `true`, `false`, and `null` MUST be in lower case.
    'constant_case' => ['case' => 'lower'],
    // PHP keywords MUST be in lower case.
    'lowercase_keywords' => true,
    // Class static references `self`, `static` and `parent` MUST be in lower case.
    'lowercase_static_reference' => true,
    // Magic constants should be referred to using the correct casing.
    'magic_constant_casing' => true,
    // Magic method definitions and calls must be using the correct casing.
    'magic_method_casing' => true,
    // In method arguments and method call, there MUST NOT be a space before each comma and there MUST be one space after each comma. Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list MUST be on the next line, and there MUST be only one argument per line.
    'method_argument_space' => true,
    // Method chaining MUST be properly indented. Method chaining with different levels of indentation is not supported.
    'method_chaining_indentation' => true,
    // Forbid multi-line whitespace before the closing semicolon or move the semicolon to the new line for chained calls.
    'multiline_whitespace_before_semicolons' => true,
    // Native type hints for functions should use the correct case.
    'native_function_type_declaration_casing' => true,
    // All instances created with new keyword must be followed by braces.
    'new_with_braces' => true,
    // Master functions shall be used instead of aliases.
    'no_alias_functions' => true,
    // Replace control structure alternative syntax to use braces.
    'no_alternative_syntax' => true,
    // There should not be a binary flag before strings.
    'no_binary_string' => true,
    // There should be no empty lines after class opening brace.
    'no_blank_lines_after_class_opening' => true,
    // There should not be blank lines between docblock and the documented element.
    'no_blank_lines_after_phpdoc' => true,
    // The closing `? >` tag MUST be omitted from files containing only PHP.
    'no_closing_tag' => true,
    // There should not be any empty comments.
    'no_empty_comment' => true,
    // There should not be empty PHPDoc blocks.
    'no_empty_phpdoc' => true,
    // Remove useless semicolon statements.
    'no_empty_statement' => true,
    // Removes extra blank lines and/or blank lines following configuration.
    'no_extra_blank_lines' => true,
    // Replace accidental usage of homoglyphs (non ascii characters) in names.
    'no_homoglyph_names' => true,
    // Remove leading slashes in `use` clauses.
    'no_leading_import_slash' => true,
    // The namespace declaration line shouldn't contain leading whitespace.
    'no_leading_namespace_whitespace' => true,
    // Either language construct `print` or `echo` should be used.
    'no_mixed_echo_print' => true,
    // Operator `=>` should not be surrounded by multi-line whitespaces.
    'no_multiline_whitespace_around_double_arrow' => true,
    // Properties MUST not be explicitly initialized with `null` except when they have a type declaration (PHP 7.4).
    'no_null_property_initialization' => true,
    // Convert PHP4-style constructors to `__construct`.
    'no_php4_constructor' => true,
    // Short cast `bool` using double exclamation mark should not be used.
    'no_short_bool_cast' => true,
    // Replace short-echo `<?=` with long format `<?php echo` syntax.
    'echo_tag_syntax' => ['format' => 'long'],
    // Single-line whitespace before closing semicolon are prohibited.
    'no_singleline_whitespace_before_semicolons' => true,
    // When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis.
    'no_spaces_after_function_name' => true,
    // There MUST NOT be spaces around offset braces.
    'no_spaces_around_offset' => true,
    // There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space before the closing parenthesis.
    'no_spaces_inside_parenthesis' => true,
    // Removes `@param`, `@return` and `@var` tags that don't provide any useful information.
    'no_superfluous_phpdoc_tags' => true,
    // Remove trailing commas in list function calls.
    'no_trailing_comma_in_list_call' => true,
    // PHP single-line arrays should not have trailing comma.
    'no_trailing_comma_in_singleline_array' => true,
    // Remove trailing whitespace at the end of non-blank lines.
    'no_trailing_whitespace' => true,
    // There MUST be no trailing spaces inside comment or PHPDoc.
    'no_trailing_whitespace_in_comment' => true,
    // Removes unneeded parentheses around control statements.
    'no_unneeded_control_parentheses' => true,
    // Removes unneeded curly braces that are superfluous and aren't part of a control structure's body.
    'no_unneeded_curly_braces' => true,
    // Variables must be set `null` instead of using `(unset)` casting.
    'no_unset_cast' => true,
    // Properties should be set to `null` instead of using `unset`.
    'no_unset_on_property' => true,
    // Unused `use` statements must be removed.
    'no_unused_imports' => true,
    // There should not be useless `else` cases.
    'no_useless_else' => true,
    // There should not be an empty `return` statement at the end of a function.
    'no_useless_return' => true,
    // In array declaration, there MUST NOT be a whitespace before each comma.
    'no_whitespace_before_comma_in_array' => true,
    // Remove trailing whitespace at the end of blank lines.
    'no_whitespace_in_blank_line' => true,
    // Array index should always be written by using square braces.
    'normalize_index_brace' => true,
    // There should not be space before or after object `T_OBJECT_OPERATOR` `->`.
    'object_operator_without_whitespace' => true,
    // Orders the elements of classes/interfaces/traits.
    'ordered_class_elements' => true,
    // Ordering `use` statements.
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    // PHPUnit assertion method calls like `->assertSame(true, $foo)` should be written with dedicated method like `->assertTrue($foo)`.
    'php_unit_construct' => true,
    // Order `@covers` annotation of PHPUnit tests.
    'phpdoc_order_by_value' => ['annotations' => ['covers']],
    // Scalar types should always be written in the same form. `int` not `integer`, `bool` not `boolean`, `float` not `real` or `double`.
    'phpdoc_scalar' => true,
    // There should be one or no space before colon, and one space after it in return type declarations, according to configuration.
    'return_type_declaration' => true,
    // A PHP file without end tag must always end with a single empty line feed.
    'single_blank_line_at_eof' => true,
    // There should be exactly one blank line before a namespace declaration.
    'single_blank_line_before_namespace' => true,
    // There MUST NOT be more than one property or constant declared per statement.
    'single_class_element_per_statement' => true,
    // There MUST be one use keyword per declaration.
    'single_import_per_statement' => true,
    // Each namespace use MUST go on its own line and there MUST be one blank line after the use statements block.
    'single_line_after_imports' => true,
    // Convert double quotes to single quotes for simple strings.
    'single_quote' => true,
    // Increment and decrement operators should be used if possible.
    'standardize_increment' => true,
    // Replace all `<>` with `!=`.
    'standardize_not_equals' => true,
    // Comparisons should be strict.
    'strict_comparison' => true,
    // All multi-line strings must use correct line ending.
    'string_line_ending' => true,
    // Standardize spaces around ternary operator.
    'ternary_operator_spaces' => true,
    // Use `null` coalescing operator `??` where possible. Requires PHP >= 7.0.
    'ternary_to_null_coalescing' => true,
    // PHP multi-line arrays should have a trailing comma.
    'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
    'trim_array_spaces' => true,
    // Visibility MUST be declared on all properties and methods; `abstract` and `final` MUST be declared before the visibility; `static` MUST be declared after the visibility.
    'visibility_required' => true,
    // Add `void` return type to functions with missing or empty return statements, but priority is given to `@return` annotations. Requires PHP >= 7.1.
    'void_return' => true,
    // In array declaration, there MUST be a whitespace after each comma.
    'whitespace_after_comma_in_array' => true,
    // Write conditions in Yoda style (`true`), non-Yoda style (`false`) or ignore those conditions (`null`) based on configuration.
    'yoda_style' => true,
  ])
  ->setFinder(
    PhpCsFixer\Finder::create()
      ->exclude('vendor')
      ->in(__DIR__ . '/src')
      ->in(__DIR__ . '/tests')
  );

return $config;
