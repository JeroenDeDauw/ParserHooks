# Commands run from inside the MediaWiki container ##########################################################

ci: test cs
test: phpunit
cs: phpcs stan

phpunit:
ifdef filter
	php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist --filter $(filter)
else
	php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist
endif

phpcs:
	vendor/bin/phpcs -p -s --standard=$(shell pwd)/phpcs.xml

stan:
	vendor/bin/phpstan analyse --configuration=phpstan.neon --memory-limit=2G

stan-baseline:
	vendor/bin/phpstan analyse --configuration=phpstan.neon --memory-limit=2G --generate-baseline
