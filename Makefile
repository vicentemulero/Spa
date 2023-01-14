.PHONY: tests/unit tests/application build

up: deps
	docker compose up -d

test: test/unit test/application
	docker compose -f docker-compose.yml down

test/coverage: .test/build deps
	docker compose -f docker-compose.yml run skeleton-php-symfony-fpm bin/phpunit --coverage-text --coverage-clover=coverage.xml --order-by=random

test/unit: .test/build
	docker compose -f docker-compose.yml run skeleton-php-symfony-fpm bin/phpunit --coverage-text --order-by=random --testsuite Unit

test/all:
	docker compose exec skeleton-php-symfony-fpm php bin/phpunit tests/

test/application: .test/build
	docker compose -f docker-compose.yml run skeleton-php-symfony-fpm bin/phpunit --coverage-text --order-by=random --testsuite Application

deps: build
	docker compose run --rm skeleton-php-symfony-fpm sh -c "\
			composer install --prefer-dist --no-progress --no-scripts --no-interaction --optimize-autoloader 	&& \
			composer dump-autoload --classmap-authoritative 													;"
bash:
	docker compose run --rm skeleton-php-symfony-fpm sh

build:
	docker compose build

down:
	docker compose -f docker-compose.yml down

.test/build:
	docker compose -f docker-compose.yml build


migrations:
	docker compose exec skeleton-php-symfony-fpm php bin/console --no-interaction doctrine:migrations:diff
	docker compose exec skeleton-php-symfony-fpm php bin/console --no-interaction doctrine:migrations:migrate

destroy:
	docker compose down -v --rmi all --remove-orphans
