# XenForo Coding Standards Fixer

[![Composer](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/composer.yml/badge.svg?branch=main&event=push)](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/composer.yml)
[![PHP-CS-Fixer](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/php-cs-fixer.yml/badge.svg?branch=main&event=push)](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/php-cs-fixer.yml)
[![PHPStan](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/phpstan.yml/badge.svg?branch=main&event=push)](https://github.com/xenforo-ltd/xf-cs-fixer/actions/workflows/phpstan.yml)

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

$config = (new ConfigHelper($finder))->getConfig();

// you may customize the configuration object further here

return $config
```

For more information, consult the [PHP Coding Standards Fixer documentation](https://cs.symfony.com/#usage).
