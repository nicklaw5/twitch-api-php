.SILENT: ;

test: cs-check test-phpunit test-phpspec

cs-check:
	vendor/bin/php-cs-fixer fix --diff --diff-format=udiff --dry-run

test-phpunit:
	vendor/bin/phpunit

test-phpspec:
	vendor/bin/phpspec run
