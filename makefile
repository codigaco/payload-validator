GNUMAKEFLAGS+=--no-print-directory --output-sync
RUN_ARGS:= $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@:)
cmd=
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
start: ## Start environment
	docker-compose up -d --force-recreate
stop: ## Stop environment
	docker-compose stop
clean-docker: ## Remove containers, network, images and volumes
	docker-compose down --rmi all --volumes --remove-orphans
build: ## Build docker images
	docker-compose build $(or $(services),${RUN_ARGS})
logs: ## Show logs
	docker-compose logs -f $(or $(services),${RUN_ARGS})

deps: ## Install dependencies
	@$(MAKE) composer cmd="install"
require: ## Require new dependency
	@$(MAKE) composer cmd="require $(or $(opts),) ${pkg}"
require-dev: ## Require new dependency
	@$(MAKE) require opts=" --dev"

cc: ## Clear symfony cache
	@$(MAKE) console cmd="cache:clear"
mi: ## Migrate all database migrations
	@$(MAKE) console cmd="doctrine:migrations:migrate"
diff: ## Generate new migration with orm changes
	@$(MAKE) console cmd="doctrine:migrations:diff"
db-drop: ## Drop database
	@$(MAKE) console cmd="doctrine:database:drop --force"
db-create: ## Create database
	@$(MAKE) console cmd="doctrine:database:create"
db-reset: db-drop db-create mi  ## Drop, create, and run migrations database
.PHONY: tests
tests: ## Run tests
	@$(MAKE) php cmd="vendor/bin/phpunit"
cs: ## Executes php cs fixer for updated or new files
	@$(MAKE) php cmd="vendor/bin/phpcs $(or $(opts),)"
check: ## Executes php cs fixer in dry run mode for updated or new files
	@$(MAKE) cs opts=" --dry-run"
style: ## Executes php analyzers
	@$(MAKE) php cmd='vendor/bin/phpstan analyse'
lint:
	@$(MAKE) php cmd='vendor/bin/grumphp run --testsuite=lint'

shell: ## Interactive shell inside docker
	@$(MAKE) run service?=php cmd=sh
console: ## Run Symfony console
	@$(MAKE) php cmd="bin/console $(or $(cmd),"${RUN_ARGS}") -e $(or $(env),dev)"
composer: ## Interactive composer
	@$(MAKE) run service=composer cmd="$(or $(cmd),${RUN_ARGS})"
php: ## Run PHP interpreter
	@$(MAKE) run service=php cmd="php $(or $(cmd),"${RUN_ARGS}")"
run: ## Run any command inside docker container
	docker-compose run --rm ${service} ${cmd}
