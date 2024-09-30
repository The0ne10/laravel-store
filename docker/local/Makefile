#-----------------------------------------------------------
# Variables
#-----------------------------------------------------------
-include .env
export USER_ID=$(shell id -u)
export GROUP_ID=$(shell id -g)
export DEFAULT_USER="1000";
export DEFAULT_GROUP="1000";
export PROJECT_NAMESPACE=test
export DEPLOY_TAG=test

export
#-----------------------------------------------------------
# Basic Commands
#-----------------------------------------------------------

up:
	docker-compose -p $(PROJECT_PREFIX) up -d --build;

down:
	docker-compose -p $(PROJECT_PREFIX) down;

fulldown:
	docker-compose -p $(PROJECT_PREFIX) down --rmi local

build:
	docker-compose -p $(PROJECT_PREFIX) build;

#-----------------------------------------------------------
# Initial installation
#-----------------------------------------------------------

init: build up laravel-env laravel-composer-install laravel-key laravel-migrate

init_env:
	test -e "./.env" || { cp ./.env.example ./.env; };

#-----------------------------------------------------------
# Laravel Commands
#-----------------------------------------------------------

php:
	docker exec -u www-data -it $(PROJECT_PREFIX)_php bash

laravel-env:
	test -e "./../../.env" || { cp ./../../.env.example ./../../.env; };

laravel-composer-install:
	docker exec -u www-data -it $(PROJECT_PREFIX)_php composer install

laravel-key:
	docker exec -u www-data -it $(PROJECT_PREFIX)_php php artisan key:generate

laravel-migrate:
	docker exec -u www-data -it $(PROJECT_PREFIX)_php php artisan migrate --seed
