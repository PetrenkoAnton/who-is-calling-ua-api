.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := wic

wic:
	docker exec -it wic_php /bin/bash
.PHONY: wic

test ok:
	docker exec -it wic_php ./vendor/bin/phpunit --group ok
.PHONY: test ok

test +:
	docker exec -it wic_php ./vendor/bin/phpunit --group +
.PHONY: test +
