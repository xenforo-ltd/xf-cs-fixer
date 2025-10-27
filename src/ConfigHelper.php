<?php

declare(strict_types=1);

namespace XFCsFixer;

use PhpCsFixer\Config;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\RuleSet\RuleSetDefinitionInterface;
use XFCsFixer\Fixer\CurlyBracesPositionFixer;
use XFCsFixer\Fixer\ElseIfFixer;
use XFCsFixer\Fixer\GroupedFunctionUseStatementFixer;
use XFCsFixer\Fixer\NoStringVariableBracesFixer;
use XFCsFixer\Fixer\UppercaseForeachAsFixer;
use XFCsFixer\RuleSet\Sets\XenForoRiskySet;
use XFCsFixer\RuleSet\Sets\XenForoSet;

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

		$this->config->registerCustomRuleSets(array_map(
			function (string $ruleSetClass): RuleSetDefinitionInterface
			{
				return new $ruleSetClass();
			},
			$this->getCustomRuleSets()
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
	 * @return list<class-string<RuleSetDefinitionInterface>>
	 */
	public function getCustomRuleSets(): array
	{
		return [
			XenForoSet::class,
			XenForoRiskySet::class,
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
			'@XF/XenForo' => true,
		];
	}

	/**
	 * @return array<string, bool|array<string, mixed>>
	 */
	public function getRiskyRules(): array
	{
		return [
			'@XF/XenForo:risky' => true,
		];
	}
}
