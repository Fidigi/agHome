SYMFONY			= php bin/console
COMPOSER		= composer
ARTEFACTS		= var/artefacts

## 
## Bases
## -----
## 

# rules based on files
composer.lock: composer.json
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

## 
## Quality assurance
## -----------------
## 

lint: ## Lints twig and yaml files
lint: lt ly

lt: vendor
	$(SYMFONY) lint:twig templates

ly: vendor
	$(SYMFONY) lint:yaml config

.PHONY: lint lt ly

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help