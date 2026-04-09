# Devs Quality Assurance

## PHPUnit Setup

Note: my setup is based on roots/bedrock, not a basic WordPress, so instructions might not be 100% accurate.

Warning: This runs on the host, not on ddev.

_TODO_: Adapt this so it runs on ddev.

_TODO_: Edit the release process. We don't want the /tests or /bin folder at all in the releases.


```bash
composer global require phpunit/phpunit:^9

bash bin/install-wp-tests.sh wordpress_test root 'mysql-pwd' localhost latest
```

### Polylang Dependency

Several regression tests verify compatibility with Polylang. The bootstrap
loads Polylang automatically when it is present in the WP test environment.

Install Polylang into the test WordPress plugin directory **before** running
PHPUnit:

```bash
# Using WP-CLI (recommended)
wp plugin install polylang --activate --path=/tmp/wordpress

# Or set the POLYLANG_DIR env var to a local checkout
export POLYLANG_DIR=/path/to/polylang
```

If Polylang is not found, Polylang-specific tests are skipped via
`markTestSkipped`.

## Running the tests

```bash
phpunit
```

In a Bedrock setup:

```bash
../../../../vendor/bin/phpunit
```

# PHPCS

## Setup

```bash
composer global require wp-coding-standards/wpcs
composer global require phpcompatibility/php-compatibility
composer global require phpcompatibility/phpcompatibility-paragonie
composer global require phpcompatibility/phpcompatibility-wp
phpcs --config-set installed_paths $HOME/.composer/vendor/wp-coding-standards/wpcs,$HOME/.composer/vendor/phpcompatibility/php-compatibility,$HOME/.composer/vendor/phpcompatibility/phpcompatibility-paragonie,$HOME/.composer/vendor/phpcompatibility/phpcompatibility-wp
```

## Running checks

Just run `phpcs` from the plugin folder.

## Future work

Some rules from the _WP Standards_ have been disabled, as they involve renaming functions, files, etc that might
be dangerous.
