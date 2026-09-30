COMPOSE_LOCAL = docker compose -f docker-compose.local.yml
COMPOSE_TEST = docker compose -f docker-compose.test.yml
SQL_FILE ?= /Users/mitbg000/Downloads/mitveepn_2026-09-25_09-01-56_mysql_data_sHJQe.sql

.PHONY: up restart stop logs test import-db shell clear-cache

up:
	$(COMPOSE_LOCAL) up -d

restart:
	$(COMPOSE_LOCAL) restart xboard

stop:
	$(COMPOSE_LOCAL) down

logs:
	$(COMPOSE_LOCAL) logs -f xboard

test:
	$(COMPOSE_TEST) run --rm app sh -lc './vendor/bin/phpunit --colors=always tests/Feature/HealthCheckTest.php'

import-db:
	$(COMPOSE_LOCAL) up -d mariadb
	$(COMPOSE_LOCAL) exec -T mariadb sh -lc 'mariadb -h127.0.0.1 -uroot -proot -e "CREATE DATABASE IF NOT EXISTS mitveepn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"'
	$(COMPOSE_LOCAL) exec -T mariadb sh -lc 'mariadb -h127.0.0.1 -uroot -proot mitveepn' < '$(SQL_FILE)'
	$(COMPOSE_LOCAL) restart xboard

shell:
	$(COMPOSE_LOCAL) exec xboard sh

clear-cache:
	$(COMPOSE_LOCAL) exec -T xboard sh -lc 'php artisan optimize:clear'