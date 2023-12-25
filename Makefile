.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := inside

inside:
	docker exec -it wic_php /bin/bash
.PHONY: inside

test ok:
	docker exec -it wic_php ./vendor/bin/phpunit --group ok
.PHONY: test ok

test +:
	docker exec -it wic_php ./vendor/bin/phpunit --group +
.PHONY: test +

doc:
	apidoc -c ./doc/v1/apidoc.json -i ./doc/v1 -o ./public/doc
.PHONY: doc
