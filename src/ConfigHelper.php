<?php

declare(strict_types=1);

namespace XFCsFixer;

use PhpCsFixer\Config;
use PhpCsFixer\Fixer\FixerInterface;
use XFCsFixer\Fixer\CurlyBracesPositionFixer;
use XFCsFixer\Fixer\ElseIfFixer;
use XFCsFixer\Fixer\GroupedFunctionUseStatementFixer;
use XFCsFixer\Fixer\NoStringVariableBracesFixer;
use XFCsFixer\Fixer\UppercaseForeachAsFixer;

final class ConfigHelper
{
	private Config $config;

	/**
	 * @param iterable<\SplFileInfo> $finder
	 */
	public function __construct(
		?iterable $finder = null,
		bool $setup = true,
		bool $allowRisky = false
	)
	{
		$this->config = new Config('XenForo');

		if ($finder !== null)
		{
			$this->config->setFinder($finder);
		}

		if ($setup)
		{
			$this->setup($allowRisky);
		}
	}

	public function getConfig(): Config
	{
		return $this->config;
	}

	public function setup(bool $allowRisky = false): void
	{
		$this->config->registerCustomFixers(array_map(
			function (string $fixerClass): FixerInterface
			{
				return new $fixerClass();
			},
			$this->getCustomFixers()
		));

		$this->config->setIndent($this->getIndent());
		$this->config->setRules($this->getRules());

		if ($allowRisky)
		{
			$this->config->setRiskyAllowed(true);
			$this->mergeRules($this->getRiskyRules());
		}
	}

	/**
	 * @param array<string, bool|array<string, mixed>> $rules
	 */
	public function mergeRules(array $rules): void
	{
		$this->config->setRules(array_merge($this->config->getRules(), $rules));
	}

	/**
	 * @return list<class-string<FixerInterface>>
	 */
	public function getCustomFixers(): array
	{
		return [
			CurlyBracesPositionFixer::class,
			ElseIfFixer::class,
			GroupedFunctionUseStatementFixer::class,
			NoStringVariableBracesFixer::class,
			UppercaseForeachAsFixer::class,
		];
	}

	/**
	 * @return non-empty-string
	 */
	public function getIndent(): string
	{
		return "\t";
	}

	/**
	 * @return array<string, bool|array<string, mixed>>
	 */
	public function getRules(): array
	{
		return [
			// base rulesets
			'@PER-CS2.0' => true,
			'@PHP71Migration' => true,

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

	/**
	 * @return array<string, bool|array<string, mixed>>
	 */
	public function getRiskyRules(): array
	{
		return [
			'@PER-CS2.0:risky' => true,
			'@PHP71Migration:risky' => true,
		];
	}
}
