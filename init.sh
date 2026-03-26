#!/bin/bash

set -e

echo "🚀 Initializing Symfony application..."

CONTAINER="app"

# Create .env
echo "Creating .env"
docker compose exec "$CONTAINER" cp .env.dev.example .env
docker compose exec "$CONTAINER" cp .env.test.example .env.test

# Install dependencies
echo "📦 Installing Composer dependencies..."
docker compose exec "$CONTAINER" composer install

# Wait for database (optional simple wait)
echo "⏳ Waiting for database connection..."
sleep 3

# Run migrations only if available
echo "🗄️ Running database migrations..."
if docker compose exec "$CONTAINER" sh -c 'test -n "$(ls migrations/*.php 2>/dev/null)"'; then
    echo "⚡ Migrations exist, running migrate..."
    docker compose exec "$CONTAINER" php bin/console doctrine:migrations:migrate --no-interaction
else
    echo "⚠️ No migration files found, skipping."
fi

# DEV Update Schema
echo "⚡ Updating Schema..."
docker compose exec "$CONTAINER" php bin/console doctrine:schema:update --force

# Load fixtures
echo "⚡ Loading fixtures..."
docker compose exec "$CONTAINER" php bin/console doctrine:fixtures:load --no-interaction

# Clear cache
echo "🧹 Clearing cache..."
docker compose exec "$CONTAINER" php bin/console cache:clear

# Warmup cache
echo "🔥 Warming up cache..."
docker compose exec "$CONTAINER" php bin/console cache:warmup

# Create admin user or other setup (optional placeholder)
# echo "👤 Creating default user..."
# docker compose exec "$CONTAINER" php bin/console app:create-user

# Load fixtures (NOT READY YET)
# echo "📊 Loading fixtures..."
# docker compose exec "$CONTAINER" php bin/console doctrine:fixtures:load --no-interaction

echo "✅ Initialization complete!"