cat > Dockerfile << 'EOF'
FROM php:8.3-cli

RUN apt-get update -y && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN php artisan config:cache

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 10000
EOF