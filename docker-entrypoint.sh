#!/bin/bash
set -e

# Wait for database to be ready
echo "Setting up Laravel application..."

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Cache configuration and routes for production
php artisan config:cache
php artisan route:cache

# Start Apache
exec apache2-foreground