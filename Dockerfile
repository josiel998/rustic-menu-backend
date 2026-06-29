FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libxml2-dev \
    dos2unix

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache

# Install Redis extension (optional but highly recommended for Laravel queue/cache)
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Convert line endings of entrypoint script and make it executable
RUN dos2unix /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

# Create supervisor logs directory
RUN mkdir -p /var/log/supervisor

# Copy application files (in production, we do this. In dev, we mount the volume)
COPY . /var/www

# Run composer install
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose ports
EXPOSE 80 8081

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
