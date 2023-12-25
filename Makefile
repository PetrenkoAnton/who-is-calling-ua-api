.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := inside

inside:
	docker exec -it wic_api_php /bin/bash
.PHONY: inside

up:
	docker-compose up -d
.PHONY: up

down:
	docker-compose down
.PHONY: down

test-ok:
	docker exec -it wic_api_php ./vendor/bin/phpunit --group ok
.PHONY: test-ok

test+:
	docker exec -it wic_api_php ./vendor/bin/phpunit --group +
.PHONY: test+

doc:
	apidoc -c ./doc/v1/apidoc.json -i ./doc/v1 -o ./public/doc
.PHONY: doc
