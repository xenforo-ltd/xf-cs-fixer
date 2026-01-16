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
		return 'Rules that follow the `XenForo <https://xenforo.com>`_ coding standards. Extends ``@PER-CS3x0:risky``.';
	}

	public function getRules(): array
	{
		$rules = [
			// base rulesets
			'@PER-CS3x0:risky' => true,
			'@PHP7x1Migration:risky' => true,
		];

		ksort($rules);

		return $rules;
	}
}
