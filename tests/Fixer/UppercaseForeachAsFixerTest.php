<?php

declare(strict_types=1);

namespace XFCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use XFCsFixer\Fixer\UppercaseForeachAsFixer;

/**
 * @extends AbstractFixerTestCase<UppercaseForeachAsFixer>
 * @covers \XFCsFixer\Fixer\UppercaseForeachAsFixer
 */
final class UppercaseForeachAsFixerTest extends AbstractFixerTestCase
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
		yield 'simple foreach with lowercase as' => [
			<<<'EXPECTED'
				<?php

				foreach ($a AS $b)
				{
					echo $b;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($a as $b)
				{
					echo $b;
				}
				INPUT,
		];

		yield 'foreach with key and value' => [
			<<<'EXPECTED'
				<?php

				foreach ($items AS $key => $value)
				{
					echo "$key: $value";
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($items as $key => $value)
				{
					echo "$key: $value";
				}
				INPUT,
		];

		yield 'uppercase AS should not change' => [
			<<<'EXPECTED'
				<?php

				foreach ($a AS $b)
				{
					echo $b;
				}
				EXPECTED,
		];

		yield 'nested foreach loops' => [
			<<<'EXPECTED'
				<?php

				foreach ($outer AS $inner)
				{
					foreach ($inner AS $item)
					{
						echo $item;
					}
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($outer as $inner)
				{
					foreach ($inner as $item)
					{
						echo $item;
					}
				}
				INPUT,
		];

		yield 'foreach on single line' => [
			<<<'EXPECTED'
				<?php

				foreach ($arr AS $val) { echo $val; }
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($arr as $val) { echo $val; }
				INPUT,
		];

		yield 'foreach with reference' => [
			<<<'EXPECTED'
				<?php

				foreach ($items AS &$item)
				{
					$item *= 2;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($items as &$item)
				{
					$item *= 2;
				}
				INPUT,
		];

		yield 'foreach with complex array expression' => [
			<<<'EXPECTED'
				<?php

				foreach (array_values($data) AS $value)
				{
					process($value);
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach (array_values($data) as $value)
				{
					process($value);
				}
				INPUT,
		];

		yield 'foreach with method call result' => [
			<<<'EXPECTED'
				<?php

				foreach ($obj->getItems() AS $item)
				{
					handle($item);
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($obj->getItems() as $item)
				{
					handle($item);
				}
				INPUT,
		];

		yield 'non-foreach as keyword should not change' => [
			<<<'EXPECTED'
				<?php

				use Foo as Bar;
				EXPECTED,
		];

		yield 'mixed foreach loops some already uppercase' => [
			<<<'EXPECTED'
				<?php

				foreach ($a AS $b)
				{
					echo $b;
				}

				foreach ($c AS $d)
				{
					echo $d;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				foreach ($a AS $b)
				{
					echo $b;
				}

				foreach ($c as $d)
				{
					echo $d;
				}
				INPUT,
		];
	}

	protected function createFixer(): UppercaseForeachAsFixer
	{
		return new UppercaseForeachAsFixer();
	}
}
