FROM dunglas/frankenphp:1-php8.4-alpine AS base
WORKDIR /app
RUN install-php-extensions pdo_pgsql mbstring opcache \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf "upload_max_filesize=3M\npost_max_size=16M\n" > "$PHP_INI_DIR/conf.d/uploads.ini"

FROM base AS build
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache unzip
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --no-scripts --no-autoloader
COPY . .
RUN composer dump-autoload --no-dev --classmap-authoritative \
    && php artisan view:cache --no-interaction

FROM base
COPY --from=build /app /app
COPY Caddyfile /etc/caddy/Caddyfile
ENV PORT=80 APP_ENV=production APP_DEBUG=false LOG_CHANNEL=stderr SESSION_SECURE_COOKIE=true
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
