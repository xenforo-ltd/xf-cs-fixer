<?php

declare(strict_types=1);

namespace XFCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use XFCsFixer\Fixer\CurlyBracesPositionFixer;

/**
 * @extends AbstractFixerTestCase<CurlyBracesPositionFixer>
 * @covers \XFCsFixer\Fixer\CurlyBracesPositionFixer
 */
final class CurlyBracesPositionFixerTest extends AbstractFixerTestCase
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
		yield 'function with return type after closing paren moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				function foo(
					int $a,
					int $b
				): int
				{
					return $a + $b;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				function foo(
					int $a,
					int $b
				): int {
					return $a + $b;
				}
				INPUT,
		];

		yield 'class method with return type after closing paren moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				class Foo
				{
					public function bar(
						string $x,
						string $y
					): string
					{
						return $x . $y;
					}
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				class Foo
				{
					public function bar(
						string $x,
						string $y
					): string {
						return $x . $y;
					}
				}
				INPUT,
		];

		yield 'brace already on own line should not change' => [
			<<<'EXPECTED'
				<?php

				function foo(
					int $a,
					int $b
				)
				{
					return $a + $b;
				}
				EXPECTED,
		];

		yield 'simple function with brace followed by newline moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				function foo()
				{
					return 1;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				function foo() {
					return 1;
				}
				INPUT,
		];

		yield 'if statement with brace followed by newline moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				if ($a)
				{
					echo $a;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a) {
					echo $a;
				}
				INPUT,
		];

		yield 'class definition with brace followed by newline moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				class Foo
				{
					public $bar;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				class Foo {
					public $bar;
				}
				INPUT,
		];

		yield 'closure with brace followed by newline moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				$fn = function ($x)
				{
					return $x * 2;
				};
				EXPECTED,
			<<<'INPUT'
				<?php

				$fn = function ($x) {
					return $x * 2;
				};
				INPUT,
		];

		yield 'anonymous class with brace followed by newline moves brace to own line' => [
			<<<'EXPECTED'
				<?php

				$obj = new class
				{
					public function test()
					{
						return true;
					}
				};
				EXPECTED,
			<<<'INPUT'
				<?php

				$obj = new class {
					public function test() {
						return true;
					}
				};
				INPUT,
		];

		yield 'method with return type on same line as closing paren' => [
			<<<'EXPECTED'
				<?php

				class Test
				{
					public function getValue(
						int $id
					): mixed
					{
						return $id;
					}
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				class Test
				{
					public function getValue(
						int $id
					): mixed {
						return $id;
					}
				}
				INPUT,
		];

		yield 'interface method declaration should not change' => [
			<<<'EXPECTED'
				<?php

				interface FooInterface
				{
					public function bar(int $a): int;
				}
				EXPECTED,
		];

		yield 'abstract method declaration should not change' => [
			<<<'EXPECTED'
				<?php

				abstract class AbstractFoo
				{
					abstract public function bar(int $a): int;
				}
				EXPECTED,
		];

		yield 'multiple methods all with brace on own line' => [
			<<<'EXPECTED'
				<?php

				class Foo
				{
					public function short()
					{
						return 1;
					}

					public function withMultipleParams(
						int $a,
						int $b
					): int
					{
						return $a + $b;
					}
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				class Foo
				{
					public function short() {
						return 1;
					}

					public function withMultipleParams(
						int $a,
						int $b
					): int {
						return $a + $b;
					}
				}
				INPUT,
		];

		yield 'inline closure should not change' => [
			<<<'EXPECTED'
				<?php

				$fn = function ($x) { return $x * 2; };
				EXPECTED,
		];
	}

	protected function createFixer(): CurlyBracesPositionFixer
	{
		return new CurlyBracesPositionFixer();
	}
}
