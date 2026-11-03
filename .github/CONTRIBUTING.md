# Contributing

Thank you for your interest in contributing to the XenForo Coding Standards Fixer.

We accept pull requests that fix bugs or implement feature requests labeled
`help wanted`.
We encourage new issues for all other contributions.
For security concerns, follow our [private disclosure policy](SECURITY.md) instead.

## Notes

- Before opening an issue, check that one does not already exist for the same problem or feature.
- Open a bug report if the fixer does not work as expected.
- Open a feature request to propose a new feature or improvement.
- Open a pull request to fix a bug or implement a feature request labeled [`help wanted`](https://github.com/xenforo-ltd/xf-cs-fixer/labels/help%20wanted).
- Do not open an issue for support. Use the [development discussions forum](https://xenforo.com/community/forums/xenforo-development-discussions.34/) instead.
- Do not open a feature pull request unless the issue is labeled `help wanted`.
- Keep each pull request focused on one bug or feature.

## Development

The Composer package is `xenforo-ltd/xf-cs-fixer`. See the [README](../README.md)
for installation and usage.

1. Install Composer and a supported PHP version (PHP 7.4 or PHP 8.x).
2. Clone the repository.
3. Run `composer install` to install dependencies.

Custom fixers and the configuration helper are in `src/`; tests are in `tests/`.
For relevant changes, consider regression coverage and whether rules remain
idempotent and compatible with supported PHP versions.

### Checks

- Use `composer php-cs-fixer:check` to check code formatting.
- Use `composer phpstan` to analyze the code.
- Use `composer phpunit` to run the tests.

Contributions to this project are released to the public under the [project's
open source license](../LICENSE).

Please note that this project adheres to a [Contributor Code of
Conduct](./CODE_OF_CONDUCT.md). By participating in this project you agree to abide
by its terms.
