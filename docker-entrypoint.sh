#!/bin/bash
set -e

# Wait for database to be ready
echo "Setting up Laravel application..."

# Always generate application key for production
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Cache configuration and routes for production
php artisan config:cache
php artisan route:cache

# Start Apache
exec apache2-foreground