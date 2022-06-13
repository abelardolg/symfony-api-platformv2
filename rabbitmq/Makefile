#!/bin/bash

RABBIT = symfony-api-platform-rabbitmq
UID = $(shell id -u)

help:
	@echo "usage: make [target]"
	@echo
	@echo "targets:"
	@echo "^(.+)\:\ ##\	(.+)" ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

run:
	U_ID=${UID} docker-compose up -d

stop:
	U_ID=${UID} docker-compose stop

restart:
	$(MAKE) stop && $(MAKE) run

build:
	U_ID=${UID} docker-compose build

ssh:
	U_ID=${UID} docker exec -it --user ${UID} ${RABBIT} bash