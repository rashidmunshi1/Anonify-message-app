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

# Run database migrations safely
echo "Waiting for database connection..."
until php artisan migrate:status --no-interaction >/dev/null 2>&1; do
    echo "Database not ready, waiting..."
    sleep 2
done

echo "Running database migrations..."
php artisan migrate --force || {
    echo "Migration failed, trying to continue..."
    # Check if tables exist and migration table is present
    if php artisan tinker --execute="echo 'DB connected';" 2>/dev/null; then
        echo "Database connected successfully, continuing..."
    else
        echo "Database connection failed!"
        exit 1
    fi
}

# Cache configuration and routes for production
php artisan config:cache
php artisan route:cache

# Start Apache
exec apache2-foreground