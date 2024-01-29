-include ./.env

.SILENT:
.NOTPARALLEL:

.DEFAULT_GOAL := inside

init:
	cp ./.env.example ./.env && cp ./phpstan.neon.dist ./phpstan.neon && echo "Created ./.env && ./.phpstan.neon files"
.PHONY: init

inside:
	docker exec -it ${APP_NAME}_php /bin/bash
.PHONY: inside

up:
	docker-compose -f ./docker-compose.yml up -d
.PHONY: up

down:
	docker-compose down
.PHONY: down

php-v:
	docker exec -it ${APP_NAME}_php php -v
.PHONY: php-v

v:
	docker exec -it ${APP_NAME}_php cat VERSION
.PHONY: v

test:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit
.PHONY: test

test-c:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit --coverage-text
.PHONY: test-c

test-ok:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit --group +
.PHONY: test+

cest:
	docker exec -it ${APP_NAME}_php ./vendor/bin/codecept run
.PHONY: cest

cest+:
	docker exec -it ${APP_NAME}_php ./vendor/bin/codecept run -g +
.PHONY: cest+

cest-smoke:
	docker exec -it ${APP_NAME}_php ./vendor/bin/codecept run -g smoke
.PHONY: cest-smoke

test-smoke:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit --group smoke --display-skipped --display-incomplete --testdox
.PHONY: test-smoke

test-xd:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpunit --group xd
.PHONY: test-xd

phpstan:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpstan --error-format=table -v
.PHONY: phpstan

phpcs:
	docker exec -it ${APP_NAME}_php ./vendor/bin/phpcs -v
.PHONY: phpcs

doc:
	apidoc -c ./doc/v1/apidoc.json -i ./doc/v1 -o ./public/doc
.PHONY: doc
