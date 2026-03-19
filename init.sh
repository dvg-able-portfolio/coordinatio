#!/bin/bash

set -e

echo "🚀 Initializing Symfony application..."

CONTAINER="app"

# Create .env
echo "Creating .env"
docker compose exec $CONTAINER cp .env.dev.example .env

# Install dependencies
echo "📦 Installing Composer dependencies..."
docker compose exec $CONTAINER composer install

# Wait for database (optional simple wait)
echo "⏳ Waiting for database connection..."
sleep 3

# Run migrations only if available
echo "🗄️ Running database migrations..."
if docker compose exec app php bin/console doctrine:migrations:status | grep -q "No migrations"; then
    echo "⚠️ No migrations found, skipping..."
else
    docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
fi

# Clear cache
echo "🧹 Clearing cache..."
docker compose exec $CONTAINER php bin/console cache:clear

# Warmup cache
echo "🔥 Warming up cache..."
docker compose exec $CONTAINER php bin/console cache:warmup

# Create admin user or other setup (optional placeholder)
# echo "👤 Creating default user..."
# docker compose exec $CONTAINER php bin/console app:create-user

# Load fixtures (NOT READY YET)
# echo "📊 Loading fixtures..."
# docker compose exec $CONTAINER php bin/console doctrine:fixtures:load --no-interaction

echo "✅ Initialization complete!"