# syntax=docker/dockerfile:1.6
# Render-friendly single-stage Dockerfile for SmartKids (Laravel 12 + Vite).
# Build cmd in Render dashboard is ignored — Docker handles install + build.

FROM php:8.3-cli-bookworm

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

# System packages: Postgres client lib, libs needed by PHP extensions,
# Node 20 from NodeSource (for Vite build).
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates curl gnupg git unzip \
        libpq-dev libicu-dev libzip-dev libpng-dev libonig-dev libxml2-dev \
        zlib1g-dev \
    ; \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -; \
    apt-get install -y --no-install-recommends nodejs; \
    rm -rf /var/lib/apt/lists/*

# PHP extensions required by Laravel + DomPDF + Postgres + Spatie permission.
RUN docker-php-ext-configure intl \
 && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql pdo_mysql mbstring bcmath gd intl zip exif pcntl opcache

# Composer (matches the version we used locally).
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dependencies first for layer caching.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-autoloader

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

# Now the rest of the source.
COPY . .

# Finalize: build front-end assets, optimize autoloader, run package discovery.
RUN composer dump-autoload --optimize \
 && php artisan package:discover --ansi \
 && npm run build \
 && rm -rf node_modules

# Permissions (Laravel needs to write to storage and bootstrap/cache).
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Render injects PORT. Default to 8000 for local docker run.
ENV PORT=8000
EXPOSE 8000

# Startup: cache config/routes/views then start the dev server bound to Render's port.
# Migrations are NOT run here — schema is owned by Supabase, populated once via local artisan.
CMD sh -c "php artisan config:cache \
        && php artisan route:cache \
        && php artisan view:cache \
        && php artisan serve --host=0.0.0.0 --port=${PORT}"
