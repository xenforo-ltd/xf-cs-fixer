<?php

declare(strict_types=1);

namespace XFCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

final class GroupedFunctionUseStatementFixer extends AbstractFixer
{
	public function getName(): string
	{
		return 'XF/grouped_function_use_statement';
	}

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'Any `use function` statements should be grouped into a single statement.',
			[new CodeSample(
				<<<'EOF'
				<?php

				use function is_array;
				use function is_int;

				EOF
			)]
		);
	}

	public function getPriority(): int
	{
		return -31;
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isAllTokenKindsFound([T_USE, CT::T_FUNCTION_IMPORT]);
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		$firstImportStartIndex = null;
		$firstImportEndIndex = null;

		$importedFunctions = [];

		foreach ($tokens AS $index => $token)
		{
			if ($token === null || !$token->isGivenKind(CT::T_FUNCTION_IMPORT))
			{
				continue;
			}

			$importStartIndex = $tokens->getPrevTokenOfKind($index, [[T_USE]]);
			if ($importStartIndex === null)
			{
				continue;
			}

			$importEndIndex = $tokens->getNextTokenOfKind($index, [';']);
			if ($importEndIndex === null)
			{
				continue;
			}

			if ($firstImportStartIndex === null)
			{
				$firstImportStartIndex = $importStartIndex;
				$firstImportEndIndex = $importEndIndex;
			}

			$importIndexRange = range(
				$importStartIndex + 1,
				$importEndIndex - 1
			);
			foreach ($importIndexRange AS $importIndex)
			{
				$importToken = $tokens[$importIndex] ?? null;
				if ($importToken === null)
				{
					continue;
				}

				if (!$importToken->isGivenKind(T_STRING))
				{
					continue;
				}

				$importedFunctions[] = $importToken->getContent();
			}

			if ($importStartIndex === $firstImportStartIndex)
			{
				continue;
			}

			$tokens->removeLeadingWhitespace($importStartIndex);
			$tokens->clearRange($importStartIndex, $importEndIndex);
		}

		if (
			$firstImportStartIndex === null ||
			$firstImportEndIndex === null ||
			$importedFunctions === []
		)
		{
			return;
		}

		$importTokens = [
			new Token([T_USE, 'use']),
			new Token([T_WHITESPACE, ' ']),
			new Token([CT::T_FUNCTION_IMPORT, 'function']),
			new Token([T_WHITESPACE, ' ']),
		];

		foreach ($importedFunctions AS $index => $importedFunction)
		{
			$importTokens[] = new Token([T_STRING, $importedFunction]);

			if ($index !== array_key_last($importedFunctions))
			{
				$importTokens[] = new Token(',');
				$importTokens[] = new Token([T_WHITESPACE, ' ']);
			}
		}

		$importTokens[] = new Token(';');

		$tokens->overrideRange(
			$firstImportStartIndex,
			$firstImportEndIndex,
			$importTokens
		);
	}
}
