<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;

/** @var ClassLoader */
$autoloader = require __DIR__ . '/../vendor/autoload.php';

$autoloader->addPsr4(
	'PhpCsFixer\\Tests\\',
	__DIR__ . '/../vendor/friendsofphp/php-cs-fixer/tests/'
);
