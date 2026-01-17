<?php

declare(strict_types=1);

namespace XFCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use XFCsFixer\Fixer\GroupedFunctionUseStatementFixer;

/**
 * @extends AbstractFixerTestCase<GroupedFunctionUseStatementFixer>
 * @covers \XFCsFixer\Fixer\GroupedFunctionUseStatementFixer
 */
final class GroupedFunctionUseStatementFixerTest extends AbstractFixerTestCase
{
	/**
	 * @dataProvider provideFixCases
	 */
	public function testFix(string $expected, ?string $input = null): void
	{
		$this->doTest($expected, $input);
	}

	/**
	 * @return iterable<string, array{0: string, 1?: string}>
	 */
	public static function provideFixCases(): iterable
	{
		yield 'two separate use function statements' => [
			<<<'EXPECTED'
				<?php

				use function is_array, is_int;
				EXPECTED,
			<<<'INPUT'
				<?php

				use function is_array;
				use function is_int;
				INPUT,
		];

		yield 'three separate use function statements' => [
			<<<'EXPECTED'
				<?php

				use function is_array, is_int, is_string;
				EXPECTED,
			<<<'INPUT'
				<?php

				use function is_array;
				use function is_int;
				use function is_string;
				INPUT,
		];

		yield 'single use function statement should not change' => [
			<<<'EXPECTED'
				<?php

				use function is_array;
				EXPECTED,
		];

		yield 'class use statements should not change' => [
			<<<'EXPECTED'
				<?php

				use Foo\Bar;
				use Baz\Qux;
				EXPECTED,
		];

		yield 'mixed class and function use statements' => [
			<<<'EXPECTED'
				<?php

				use Foo\Bar;
				use function is_array, is_int;
				use Baz\Qux;
				EXPECTED,
			<<<'INPUT'
				<?php

				use Foo\Bar;
				use function is_array;
				use function is_int;
				use Baz\Qux;
				INPUT,
		];

		yield 'use const statements should not change' => [
			<<<'EXPECTED'
				<?php

				use const Foo\BAR;
				use const Baz\QUX;
				EXPECTED,
		];

		yield 'no use statements should not change' => [
			<<<'EXPECTED'
				<?php

				class Foo
				{
					public function bar()
					{
						return is_array([]);
					}
				}
				EXPECTED,
		];

		yield 'already grouped function use statement should not change' => [
			<<<'EXPECTED'
				<?php

				use function is_array, is_int, is_string;
				EXPECTED,
		];

		yield 'use function with many functions' => [
			<<<'EXPECTED'
				<?php

				use function array_map, array_filter, array_reduce, array_merge, array_keys;
				EXPECTED,
			<<<'INPUT'
				<?php

				use function array_map;
				use function array_filter;
				use function array_reduce;
				use function array_merge;
				use function array_keys;
				INPUT,
		];
	}

	protected function createFixer(): GroupedFunctionUseStatementFixer
	{
		return new GroupedFunctionUseStatementFixer();
	}
}
