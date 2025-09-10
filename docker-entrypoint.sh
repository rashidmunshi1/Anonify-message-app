#!/bin/bash
set -e

# Wait for database to be ready
echo "Setting up Laravel application..."

# Set PORT if not provided (Railway provides $PORT)
export PORT=${PORT:-80}

# Update Apache ports configuration
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/:80>/:$PORT>/g" /etc/apache2/sites-available/000-default.conf

# Always generate application key for production  
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Cache configuration and routes for production
php artisan config:cache
php artisan route:cache

# Start Apache
exec apache2-foreground