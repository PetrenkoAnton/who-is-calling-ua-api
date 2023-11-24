.SILENT:
.NOTPARALLEL:

## Settings
.DEFAULT_GOAL := wic

wic:
	docker exec -it wic_php /bin/bash
.PHONY: wic
