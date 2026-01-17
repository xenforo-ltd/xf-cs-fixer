<?php

declare(strict_types=1);

namespace XFCsFixer\Tests;

use PHPUnit\Framework\TestCase;
use XFCsFixer\ConfigHelper;

/**
 * @covers \XFCsFixer\ConfigHelper
 */
final class ConfigHelperTest extends TestCase
{
	public function testSetup(): void
	{
		$configHelper = new ConfigHelper(null, false);
		$config = $configHelper->getConfig();

		static::assertSame('XenForo', $config->getName());
		static::assertEmpty($config->getCustomFixers());
		static::assertEmpty($config->getCustomRuleSets());
		static::assertFalse($config->getRiskyAllowed());

		$configHelper->setup();

		static::assertNotEmpty($config->getCustomFixers());
		static::assertNotEmpty($config->getCustomRuleSets());
		static::assertFalse($config->getRiskyAllowed());
		static::assertSame("\t", $config->getIndent());

		$configHelper = new ConfigHelper(null, true, true);
		$config = $configHelper->getConfig();

		static::assertTrue($config->getRiskyAllowed());
	}

	public function testMergeRules(): void
	{
		$configHelper = new ConfigHelper();
		$config = $configHelper->getConfig();

		static::assertSame(['@XF/XenForo' => true], $config->getRules());

		$configHelper->mergeRules([
			'encoding' => true,
		]);

		static::assertSame(
			['@XF/XenForo' => true, 'encoding' => true],
			$config->getRules()
		);
	}
}
