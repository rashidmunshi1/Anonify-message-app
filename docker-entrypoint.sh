#!/bin/bash
set -e

echo "Setting up Laravel application..."

# Set PORT if not provided (Railway provides $PORT)
export PORT=${PORT:-8000}
echo "Using PORT: $PORT"

# Change to Laravel directory
cd /var/www/html

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

# Cache configuration for production
php artisan config:cache

echo "Starting PHP server on 0.0.0.0:$PORT"
# Start PHP built-in server
exec php artisan serve --host=0.0.0.0 --port=$PORT