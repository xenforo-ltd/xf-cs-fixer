<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;

/** @var ClassLoader */
$autoloader = require __DIR__ . '/../vendor/autoload.php';

$phpCsFixerTestsPath = __DIR__ . '/../vendor/friendsofphp/php-cs-fixer/tests/';
if (is_dir($phpCsFixerTestsPath))
{
	$autoloader->addPsr4('PhpCsFixer\\Tests\\', $phpCsFixerTestsPath);
}
