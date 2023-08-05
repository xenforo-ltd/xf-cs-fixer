<?php

declare(strict_types=1);

namespace XFCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\Indentation;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class CurlyBracesPositionFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
	use Indentation;

	public function getName(): string
	{
		return 'XF/curly_braces_position';
	}

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'The open brace of a block should be placed on its own line.',
			[new CodeSample(
				<<<'EOF'
				<?php

				function foo(
					int $a,
					int $b
				): int {
					return $a + $b;
				}

				EOF
			)]
		);
	}

	public function getPriority(): int
	{
		return -3;
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound('{');
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		foreach ($tokens AS $index => $token)
		{
			if ($token === null || !$token->equals('{'))
			{
				continue;
			}

			$nextToken = $tokens[$index + 1] ?? null;
			if (
				$nextToken === null ||
				!$nextToken->isGivenKind(T_WHITESPACE) ||
				strpos($nextToken->getContent(), "\n") !== 0
			)
			{
				continue;
			}

			$previousNonWhitespaceIndex = $tokens->getPrevNonWhitespace($index);
			if ($previousNonWhitespaceIndex === null)
			{
				continue;
			}

			$lineEnding = $this->whitespacesConfig->getLineEnding();
			$lineIndentation = $this->getLineIndentation($tokens, $index);
			$whitespace = $lineEnding . $lineIndentation;
			$tokens->overrideRange($previousNonWhitespaceIndex + 1, $index - 1, [
				new Token([T_WHITESPACE, $whitespace]),
			]);
		}
	}
}
