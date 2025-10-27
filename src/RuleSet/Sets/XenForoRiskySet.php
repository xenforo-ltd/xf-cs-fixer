<?php

declare(strict_types=1);

namespace XFCsFixer\RuleSet\Sets;

use PhpCsFixer\RuleSet\AbstractRuleSetDefinition;

final class XenForoRiskySet extends AbstractRuleSetDefinition
{
	public function getName(): string
	{
		return '@XF/XenForo:risky';
	}
	public function getDescription(): string
	{
		return 'Rules that follow the `XenForo` standard.';
	}

	public function getRules(): array
	{
		return [
			// base rulesets
			'@PER-CS2x0:risky' => true,
			'@PHP7x1Migration:risky' => true,
		];
	}
}
