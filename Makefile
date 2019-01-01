.SILENT: ;

test: test-phpunit test-phpspec

test-phpunit:
	vendor/bin/phpunit

test-phpspec:
	vendor/bin/phpspec run
