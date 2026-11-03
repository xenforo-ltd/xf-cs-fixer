# XenForo Coding Standards Fixer

<img src="assets/icon-rounded.svg" width="96" hspace="16" vspace="4" align="left" alt="XenForo Coding Standards Fixer icon" />

[![XenForo](https://img.shields.io/badge/XenForo-%230F578A)](https://xenforo.com)
[![License](https://img.shields.io/packagist/l/xenforo-ltd/xf-cs-fixer?label=license)](https://packagist.org/packages/xenforo-ltd/xf-cs-fixer)
[![Version](https://img.shields.io/packagist/v/xenforo-ltd/xf-cs-fixer?label=version)](https://packagist.org/packages/xenforo-ltd/xf-cs-fixer)
[![Status](https://img.shields.io/github/check-runs/xenforo-ltd/xf-cs-fixer/main?label=status)](https://github.com/xenforo-ltd/xf-cs-fixer/actions)

A [PHP Coding Standards Fixer](https://cs.symfony.com) configuration for the
XenForo code style. It provides a configuration helper and custom rules that
supplement the built-in [PER-CS](https://cs.symfony.com/doc/ruleSets/PER-CS.html)
rule set.

## Installation

Install the package with [Composer](https://getcomposer.org):

```bash
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
	->ignoreVCSIgnored(true);

$helper = new ConfigHelper($finder);

return $helper->getConfig();
```

Check or fix your project's formatting:

```bash
vendor/bin/php-cs-fixer check
vendor/bin/php-cs-fixer fix
```

For more information, consult the [PHP Coding Standards Fixer documentation](https://cs.symfony.com/#usage).

## Security

Do not report security vulnerabilities in public issues.

See [SECURITY.md](.github/SECURITY.md) for vulnerability reporting instructions.

## Support

For usage questions, ask in the
[development discussions forum](https://xenforo.com/community/forums/xenforo-development-discussions.34/).
For bug reports and feature requests, use this repository's
[GitHub Issues](https://github.com/xenforo-ltd/xf-cs-fixer/issues).

For support guidance, see [SUPPORT.md](.github/SUPPORT.md).

## Contributing

See [CONTRIBUTING.md](.github/CONTRIBUTING.md) for development and contribution
guidelines.

## License

Copyright (c) XenForo Ltd. All rights reserved.

This project is licensed under the MIT License. See [LICENSE](LICENSE) for
details.
