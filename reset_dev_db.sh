#!/bin/bash
set -e

# Name of your PHP container
CONTAINER="app" # change if your container has a different name

echo "=============================="
echo "⚡ Resetting database schema..."
echo "=============================="

# Drop all tables (keeps the database itself)
docker compose exec "$CONTAINER" php bin/console doctrine:schema:drop --force || true

# Create schema from current entities
docker compose exec "$CONTAINER" php bin/console doctrine:schema:update --force

echo "=============================="
echo "🗄️ Running migrations if available..."
echo "=============================="

# Run migrations only if any migration files exist
if docker compose exec "$CONTAINER" sh -c 'test -n "$(ls migrations/*.php 2>/dev/null)"'; then
    echo "⚡ Migrations found, running..."
    docker compose exec "$CONTAINER" php bin/console doctrine:migrations:migrate --no-interaction
else
    echo "⚠️ No migrations found, skipping migration."
fi

echo "=============================="
echo "⚡ Loading fixtures..."
echo "=============================="

# Load all fixtures (JSON or ORM fixtures)
docker compose exec "$CONTAINER" php bin/console doctrine:fixtures:load --no-interaction

echo "=============================="
echo "✅ Database reset complete!"
echo "=============================="