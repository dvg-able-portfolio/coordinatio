# Use latest PHP-FPM Alpine image
FROM php:8.5-fpm-alpine

# 
RUN apk add --no-cache icu-dev bash postgresql-dev git curl openssh

RUN docker-php-ext-install pdo_pgsql pgsql

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/app

# For development
RUN adduser -D -u 1000 -h /home/appuser appuser
RUN mkdir -p /var/app/var/cache /var/app/var/log /home/appuser/.composer \
    && chown -R 1000:1000 /var/app/var /home/appuser/.composer
USER appuser
ENV HOME=/home/appuser
ENV COMPOSER_HOME=/home/appuser/.composer

# Copy your application code
COPY . .


# Expose the port PHP-FPM listens on
EXPOSE 9000

# Start both PHP-FPM and Caddy (using a shell to run both)
CMD ["php-fpm"]