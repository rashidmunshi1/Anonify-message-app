# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

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

# Create basic .env file
RUN echo "APP_NAME=Anonify" > /var/www/html/.env && \
    echo "APP_ENV=production" >> /var/www/html/.env && \
    echo "APP_KEY=" >> /var/www/html/.env && \
    echo "APP_DEBUG=false" >> /var/www/html/.env && \
    echo "APP_URL=https://your-app.com" >> /var/www/html/.env && \
    echo "LOG_CHANNEL=stack" >> /var/www/html/.env && \
    echo "LOG_LEVEL=error" >> /var/www/html/.env && \
    echo "DB_CONNECTION=mysql" >> /var/www/html/.env && \
    echo "DB_HOST=127.0.0.1" >> /var/www/html/.env && \
    echo "DB_PORT=3306" >> /var/www/html/.env && \
    echo "DB_DATABASE=laravel" >> /var/www/html/.env && \
    echo "DB_USERNAME=root" >> /var/www/html/.env && \
    echo "DB_PASSWORD=" >> /var/www/html/.env && \
    echo "BROADCAST_DRIVER=log" >> /var/www/html/.env && \
    echo "CACHE_DRIVER=file" >> /var/www/html/.env && \
    echo "FILESYSTEM_DISK=local" >> /var/www/html/.env && \
    echo "QUEUE_CONNECTION=sync" >> /var/www/html/.env && \
    echo "SESSION_DRIVER=file" >> /var/www/html/.env && \
    echo "SESSION_LIFETIME=120" >> /var/www/html/.env

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown www-data:www-data /var/www/html/.env

# Enable Apache rewrite module
RUN a2enmod rewrite

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy and make startup script executable
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

# Use custom entrypoint
CMD ["docker-entrypoint.sh"]