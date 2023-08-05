<?php

declare(strict_types=1);

namespace XFCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class ElseIfFixer extends AbstractFixer
{
	public function getName(): string
	{
		return 'XF/else_if';
	}

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'The `else if` keywords should be used instead of `elseif`.',
			[new CodeSample(
				<<<'EOF'
				<?php

				if ($a)
				{
					echo $a;
				}
				elseif ($b)
				{
					echo $b;
				}

				EOF
			)]
		);
	}

	public function getPriority(): int
	{
		return 39;
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound(T_ELSEIF);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		foreach ($tokens AS $index => $token)
		{
			if ($token === null || !$token->isGivenKind(T_ELSEIF))
			{
				continue;
			}

			$tokens->overrideRange($index, $index, [
				new Token([T_ELSE, 'else']),
				new Token([T_WHITESPACE, ' ']),
				new Token([T_IF, 'if']),
			]);
		}
	}
}
