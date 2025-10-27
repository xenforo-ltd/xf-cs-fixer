<?php

declare(strict_types=1);

namespace XFCsFixer\RuleSet\Sets;

use PhpCsFixer\RuleSet\AbstractRuleSetDefinition;

final class XenForoSet extends AbstractRuleSetDefinition
{
	public function getName(): string
	{
		return '@XF/XenForo';
	}

	public function getDescription(): string
	{
		return 'Rules that follow the `XenForo` standard.';
	}

	public function getRules(): array
	{
		return [
			// base rulesets
			'@PER-CS2x0' => true,
			'@PHP7x1Migration' => true,

			// custom fixers
			'XF/curly_braces_position' => true,
			'XF/else_if' => true,
			'XF/grouped_function_use_statement' => true,
			'XF/uppercase_foreach_as' => true,

			// extra fixers
			'fully_qualified_strict_types' => [
				'import_symbols' => true,
				'leading_backslash_in_global_namespace' => true,
			],
			'global_namespace_import' => [
				'import_classes' => false,
				'import_constants' => false,
				'import_functions' => null,
			],
			'include' => true,
			'no_unneeded_import_alias' => true,
			'no_unused_imports' => true,
			'nullable_type_declaration_for_default_null_value' => true,
			'ordered_imports' => [
				'imports_order' => ['class', 'function', 'const'],
				'sort_algorithm' => 'alpha',
			],

			// @PER-CS2.0 disablers
			'single_line_empty_body' => false,

			// @PSR2 customizations
			'braces_position' => [  // we use allman braces
				'control_structures_opening_brace' => 'next_line_unless_newline_at_signature_end',
			],
			'control_structure_continuation_position' => [ // we use allman braces
				'position' => 'next_line',
			],
			'function_declaration' => [
				'closure_fn_spacing' => 'one',
			],

			// @PER-CS2.0 customizations
			'trailing_comma_in_multiline' => [ // retain PHP 7.2 compatibility
				'elements' => ['arrays'],
			],
		];
	}
}
