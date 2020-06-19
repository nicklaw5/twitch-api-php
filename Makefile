.SILENT: ;

test: cs-check test-phpunit test-phpspec

cs-check:
	vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation

test-phpunit:
	vendor/bin/phpunit

test-phpspec:
	vendor/bin/phpspec run
