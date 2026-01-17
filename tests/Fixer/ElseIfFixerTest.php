<?php

declare(strict_types=1);

namespace XFCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;
use XFCsFixer\Fixer\ElseIfFixer;

/**
 * @extends AbstractFixerTestCase<ElseIfFixer>
 * @covers \XFCsFixer\Fixer\ElseIfFixer
 */
final class ElseIfFixerTest extends AbstractFixerTestCase
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
		yield 'simple elseif to else if' => [
			<<<'EXPECTED'
				<?php

				if ($a)
				{
					echo $a;
				}
				else if ($b)
				{
					echo $b;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a)
				{
					echo $a;
				}
				elseif ($b)
				{
					echo $b;
				}
				INPUT,
		];

		yield 'multiple elseif blocks' => [
			<<<'EXPECTED'
				<?php

				if ($a)
				{
					echo $a;
				}
				else if ($b)
				{
					echo $b;
				}
				else if ($c)
				{
					echo $c;
				}
				else
				{
					echo "default";
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a)
				{
					echo $a;
				}
				elseif ($b)
				{
					echo $b;
				}
				elseif ($c)
				{
					echo $c;
				}
				else
				{
					echo "default";
				}
				INPUT,
		];

		yield 'else if already used should not change' => [
			<<<'EXPECTED'
				<?php

				if ($a)
				{
					echo $a;
				}
				else if ($b)
				{
					echo $b;
				}
				EXPECTED,
		];

		yield 'nested elseif' => [
			<<<'EXPECTED'
				<?php

				if ($a)
				{
					if ($x)
					{
						echo $x;
					}
					else if ($y)
					{
						echo $y;
					}
				}
				else if ($b)
				{
					echo $b;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a)
				{
					if ($x)
					{
						echo $x;
					}
					elseif ($y)
					{
						echo $y;
					}
				}
				elseif ($b)
				{
					echo $b;
				}
				INPUT,
		];

		yield 'elseif on same line' => [
			<<<'EXPECTED'
				<?php

				if ($a) {
					echo $a;
				} else if ($b) {
					echo $b;
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a) {
					echo $a;
				} elseif ($b) {
					echo $b;
				}
				INPUT,
		];

		yield 'elseif with complex condition' => [
			<<<'EXPECTED'
				<?php

				if ($a && $b)
				{
					echo "a and b";
				}
				else if ($c || $d)
				{
					echo "c or d";
				}
				else if (!$e)
				{
					echo "not e";
				}
				EXPECTED,
			<<<'INPUT'
				<?php

				if ($a && $b)
				{
					echo "a and b";
				}
				elseif ($c || $d)
				{
					echo "c or d";
				}
				elseif (!$e)
				{
					echo "not e";
				}
				INPUT,
		];
	}

	protected function createFixer(): ElseIfFixer
	{
		return new ElseIfFixer();
	}
}
