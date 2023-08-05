<?php

declare(strict_types=1);

namespace XFCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class UppercaseForeachAsFixer extends AbstractFixer
{
	public function getName(): string
	{
		return 'XF/uppercase_foreach_as';
	}

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'The `as` keyword of a `foreach` control structure should be in upper case.',
			[new CodeSample(
				<<<'EOF'
				<?php

				foreach ($a as $b)
				{
					echo $b;
				}

				EOF
			)]
		);
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isAllTokenKindsFound([T_FOREACH, T_AS]);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		foreach ($tokens AS $index => $token)
		{
			if ($token === null || !$token->isGivenKind(T_FOREACH))
			{
				continue;
			}

			$asIndex = $tokens->getNextTokenOfKind($index, [[T_AS]]);
			if ($asIndex === null)
			{
				continue;
			}

			$asToken = $tokens[$asIndex] ?? null;
			if ($asToken === null || $asToken->getId() === null)
			{
				continue;
			}

			$tokens[$asIndex] = new Token([
				$asToken->getId(),
				strtoupper($asToken->getContent()),
			]);
		}
	}
}
