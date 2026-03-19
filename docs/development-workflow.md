# Development Workflow

## Run Tests

docker compose exec php php bin/phpunit

## Run Linter

docker compose exec php vendor/bin/php-cs-fixer fix

## Run Static Analysis

docker compose exec php vendor/bin/phpstan analyse