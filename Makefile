SYMFONY			= php bin/console
COMPOSER		= composer
ARTEFACTS		= var/artefacts

## 
## Bases
## -----
## 

install: ## Run installation process
install: vendor

.PHONY: install

# rules based on files
composer.lock: composer.json
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

# Requierements
artefacts-phpunit: 
	@if [ ! -f $(ARTEFACTS)/phpunit.lock ]; \
	then\
		mkdir -p $(ARTEFACTS)/phpunit/global; \
		mkdir -p $(ARTEFACTS)/phpunit/mvp; \
		mkdir -p $(ARTEFACTS)/phpunit/cmd; \
		mkdir -p $(ARTEFACTS)/phpunit/u; \
		mkdir -p $(ARTEFACTS)/phpunit/f; \
		touch $(ARTEFACTS)/phpunit.lock; \
	fi

req-phpunit: vendor artefacts-phpunit
	@if [ ! -f bin/phpunit ]; \
	then\
		echo "phpunit est absent.\nVoulez vous installer phpunit ? \no) Oui\nn) Non"; \
		read reponse; \
		if [ "$$reponse" = "o" ]; \
		then\
			echo "Installation de phpunit"; \
			$(COMPOSER) req --dev test-pack; \
		else\
			echo "Impossible de lancer phpunit"; \
			return 1; \
		fi; \
	fi

## 
## Tests
## -----
## 

test: ## Run all the kind tests
test: req-phpunit
	php bin/phpunit --coverage-html=$(ARTEFACTS)/phpunit/global/

tmvp: ## Run MVP (Minimum Viable Product) tests
tmvp: req-phpunit
	php bin/phpunit --coverage-html=$(ARTEFACTS)/phpunit/mvp/ --group mvp

tcmd: ## Run command (App/Command) tests
tcmd: req-phpunit
	php bin/phpunit --coverage-html=$(ARTEFACTS)/phpunit/cmd/ --group cmd

tu: ## Run unit tests
tu: req-phpunit
	php bin/phpunit --coverage-html=$(ARTEFACTS)/phpunit/u/ --exclude-group functional,mvp,cmd

tf: ## Run functional tests
tf: req-phpunit
	php bin/phpunit --coverage-html=$(ARTEFACTS)/phpunit/f/ --group functional

.PHONY: test tcmd tmvp tu tf

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