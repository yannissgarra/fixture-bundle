init-database-test:
	./bin/console doctrine:database:drop --force --no-interaction --env=test
	./bin/console doctrine:database:create --no-interaction --env=test
	./bin/console doctrine:schema:update --complete --force --no-interaction --env=test