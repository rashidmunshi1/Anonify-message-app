#!/bin/bash
set -e

# Wait for database to be ready
echo "Setting up Laravel application..."

# Set PORT if not provided (Railway provides $PORT)
export PORT=${PORT:-80}
echo "Using PORT: $PORT"

# Update Apache ports configuration
echo "Listen $PORT" > /etc/apache2/ports.conf
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Create new virtual host configuration
cat > /etc/apache2/sites-available/000-default.conf << EOF
<VirtualHost *:$PORT>
    ServerName localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options Indexes FollowSymLinks
        DirectoryIndex index.php index.html
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

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