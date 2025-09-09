# Use PHP 8.1 with Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY --chown=www-data:www-data . /var/www/html

# Run composer dump-autoload
RUN composer dump-autoload --optimize

# Create SQLite database file
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chmod 664 /var/www/html/database/database.sqlite \
    && chown www-data:www-data /var/www/html/database/database.sqlite

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Generate application key and run migrations
RUN php artisan key:generate --force \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]