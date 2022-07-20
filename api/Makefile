#!/bin/bash

DOCKER_BE = symfony-api-platform-be
OS := $(shell uname)

ifeq ($(OS), Darwin)
	UID = $(shell id -u)
else ifeq ($(OS), Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

help: ## Show this help message
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@egrep "^(.+)\:\ ##\ (.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

run: ## start the containers
	docker network create symfony-api-platform-network || true
	U_ID=${UID} docker-compose up -d

stop: ## stop the containers
	U_ID=${UID} docker-compose stop

restart: ## restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## build the containers
	U_ID=${UID} docker-compose build

prepare:
	$(MAKE) composer-install

composer-install: ## installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

migrations: ## Runs the migrations
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console doctrine:migrations:migrate -n

be-logs: ## Tails the Symfony dev log
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} tail -f var/log/dev.log

ssh-be: ## ssh's into the be container
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bash

code-style: ## Runs php-cs fixer to fix code styling following Symfony rules
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony

generate-ssh:  ## Generates public and private certifications
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} mkdir -p config/jwt
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} openssl genrsa -passout pass:5489bcab50749aa7052d3f83bc87eae8 -out config/jwt/private.pem -aes256 4096
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} openssl rsa -pubout --passin pass:5489bcab50749aa7052d3f83bc87eae8 -in config/jwt/private.pem -out config/jwt/public.pem