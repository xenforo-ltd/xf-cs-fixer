# XenForo Coding Standards Fixer

[![XenForo](https://img.shields.io/badge/XenForo-%230F578A)](https://xenforo.com)
[![License](https://img.shields.io/packagist/l/xenforo-ltd/xf-cs-fixer?label=license)](https://packagist.org/packages/xenforo-ltd/xf-cs-fixer)
[![Version](https://img.shields.io/packagist/v/xenforo-ltd/xf-cs-fixer?label=version)](https://packagist.org/packages/xenforo-ltd/xf-cs-fixer)
[![Status](https://img.shields.io/github/check-runs/xenforo-ltd/xf-cs-fixer/main?label=status)](https://github.com/xenforo-ltd/xf-cs-fixer/actions)

A [PHP Coding Standards Fixer](https://cs.symfony.com) configuration for [XenForo](https://xenforo.com).

This library provides a configuration helper and a handful of additional rules
which supplement the built-in [PER-CS](https://cs.symfony.com/doc/ruleSets/PER-CS.html)
rule set to automatically format code according to the XenForo code style.

## Installing

To use our configuration or rules, install them with [Composer](https://getcomposer.org):

```
composer require --dev xenforo-ltd/xf-cs-fixer
```

## Usage

Create a `.php-cs-fixer.dist.php` configuration file in your project directory:

```php
<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use XFCsFixer\ConfigHelper;

$finder = Finder::create()
	->in(__DIR__)
	->ignoreVCSIgnored(true)
	->notPath([
		// you may set paths or path patterns to exclude here
	]);

$helper = new ConfigHelper($finder);

// you may customize the rules or configuration further here

return $helper->getConfig();
```

For more information, consult the [PHP Coding Standards Fixer documentation](https://cs.symfony.com/#usage).
