<?php

declare(strict_types=1);

namespace XFCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use XFCsFixer\Fixer\NoStringVariableBracesFixer;

/**
 * @extends AbstractFixerTestCase<NoStringVariableBracesFixer>
 * @covers \XFCsFixer\Fixer\NoStringVariableBracesFixer
 */
final class NoStringVariableBracesFixerTest extends AbstractFixerTestCase
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
		yield 'simple variable in double-quoted string' => [
			<<<'EXPECTED'
				<?php
				$name = "John";
				echo "Hello $name!";
				EXPECTED,
			<<<'INPUT'
				<?php
				$name = "John";
				echo "Hello {$name}!";
				INPUT,
		];

		yield 'multiple variables in string' => [
			<<<'EXPECTED'
				<?php
				$first = "John";
				$last = "Doe";
				echo "Hello $first $last!";
				EXPECTED,
			<<<'INPUT'
				<?php
				$first = "John";
				$last = "Doe";
				echo "Hello {$first} {$last}!";
				INPUT,
		];

		yield 'variable without braces should not change' => [
			<<<'EXPECTED'
				<?php
				$name = "John";
				echo "Hello $name!";
				EXPECTED,
		];

		yield 'array access with braces should not change' => [
			<<<'EXPECTED'
				<?php
				$arr = ["key" => "value"];
				echo "Value: {$arr['key']}";
				EXPECTED,
		];

		yield 'object property with braces should not change' => [
			<<<'EXPECTED'
				<?php
				$obj = new stdClass();
				$obj->name = "John";
				echo "Hello {$obj->name}!";
				EXPECTED,
		];

		yield 'heredoc with variable' => [
			<<<'EXPECTED'
				<?php
				$name = "John";
				$str = <<<EOT
				Hello $name!
				EOT;
				EXPECTED,
			<<<'INPUT'
				<?php
				$name = "John";
				$str = <<<EOT
				Hello {$name}!
				EOT;
				INPUT,
		];

		yield 'nowdoc should not change' => [
			<<<'EXPECTED'
				<?php
				$name = "John";
				$str = <<<'EOT'
				Hello {$name}!
				EOT;
				EXPECTED,
		];

		yield 'single-quoted string should not change' => [
			<<<'EXPECTED'
				<?php
				$name = "John";
				echo 'Hello {$name}!';
				EXPECTED,
		];

		yield 'mixed braced and unbraced variables' => [
			<<<'EXPECTED'
				<?php
				$a = "foo";
				$b = "bar";
				echo "$a and $b";
				EXPECTED,
			<<<'INPUT'
				<?php
				$a = "foo";
				$b = "bar";
				echo "{$a} and $b";
				INPUT,
		];

		yield 'method call in braces should not change' => [
			<<<'EXPECTED'
				<?php
				class Foo {
					public function getName() { return "test"; }
				}
				$obj = new Foo();
				echo "Name: {$obj->getName()}";
				EXPECTED,
		];
	}

	protected function createFixer(): NoStringVariableBracesFixer
	{
		return new NoStringVariableBracesFixer();
	}
}
