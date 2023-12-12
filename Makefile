.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := wic

wic:
	docker exec -it wic_php /bin/bash
.PHONY: wic

test:
	docker exec -it wic_php ./vendor/bin/phpunit
.PHONY: test

test +:
	docker exec -it wic_php ./vendor/bin/phpunit --group +
.PHONY: test +
