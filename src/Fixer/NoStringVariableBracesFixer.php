<?php

declare(strict_types=1);

namespace XFCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;

final class NoStringVariableBracesFixer extends AbstractFixer
{
	public function getName(): string
	{
		return 'XF/no_string_variable_braces';
	}

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			"Remove braces from variables in strings.",
			[new CodeSample(
				<<<'EOF'
				'<?php
				$name = "John";
				echo "Hello {$name}!";
				echo "Value: {$value[0]}";

				EOF
			)]
		);
	}

	public function getPriority(): int
	{
		return -10;
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound(T_CURLY_OPEN);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		foreach ($tokens AS $index => $token)
		{
			if ($token === null || !$token->isGivenKind(T_CURLY_OPEN))
			{
				continue;
			}

			$variableIndex = $tokens->getNextMeaningfulToken($index);
			if ($variableIndex === null)
			{
				return;
			}

			$variableToken = $tokens[$variableIndex];
			if (!$variableToken->isGivenKind(T_VARIABLE))
			{
				return;
			}

			$curlyCloseIndex = $tokens->getNextMeaningfulToken($variableIndex);
			if ($curlyCloseIndex === null)
			{
				return;
			}

			$curlyCloseToken = $tokens[$curlyCloseIndex];
			if ($curlyCloseToken->getContent() !== '}')
			{
				return;
			}

			$tokens->clearAt($index);
			$tokens->clearAt($curlyCloseIndex);
		}
	}
}
