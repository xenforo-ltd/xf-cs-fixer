<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use XFCsFixer\ConfigHelper;

$finder = Finder::create()
	->in(__DIR__)
	->ignoreVCSIgnored(true)
	->notPath([
		'phpstan-baseline.php',
	]);

return (new ConfigHelper($finder))->getConfig();
