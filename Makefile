# Coordinatio Makefile
# All commands run inside the Docker container (app)
bash:
	docker exec -it app bash

composer-install:
	docker compose exec app composer install

fixer-fix:
	docker compose exec app vendor/bin/php-cs-fixer fix --allow-risky=yes

fixer-fix-dry:
	docker compose exec app vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run

cache-clear:
	docker compose exec app php bin/console cache:clear

debug-router:
	docker compose exec app php bin/console debug:router

make-controller:
	docker compose exec app php bin/console make:controller

.PHONY: composer-install cache-clear make-controller bash fixer-fix fixer-fix-dry debug-router