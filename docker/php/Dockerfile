# --- Stage 1: build frontend assets (Tailwind/Vite) ---
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# --- Stage 2: PHP-FPM application image ---
# NOTE: composer.lock was resolved on a PHP 8.5 host, which pulled in
# transitive packages (e.g. symfony/error-handler) requiring PHP >= 8.4.1.
FROM php:8.4-fpm-alpine

RUN apk add --no-cache libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath zip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader

COPY --from=node-builder /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
