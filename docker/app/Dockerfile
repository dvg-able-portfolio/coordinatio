# Use latest PHP-FPM Alpine image
FROM php:8.5-fpm-alpine

# Install packages
RUN apk add --no-cache \
    git \
    curl \ 
    openssh \
    bash \
    unzip \
    wget \
    chromium \
    chromium-chromedriver \
    firefox \
    geckodriver \
    libzip-dev \
    libpq-dev \
    postgresql-dev \
    zip \
    && docker-php-ext-install pdo_pgsql zip

RUN docker-php-ext-install pdo_pgsql pgsql zip

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set environment variables for Panther (optional)
ENV PANTHER_NO_SANDBOX=1

# Set working directory
WORKDIR /var/app

# For development
RUN adduser -D -u 1000 -h /home/appuser appuser
RUN mkdir -p /var/app/var/cache /var/app/var/log /home/appuser/.composer \
    && chown -R 1000:1000 /var/app/var /home/appuser/.composer
USER appuser
ENV HOME=/home/appuser
ENV COMPOSER_HOME=/home/appuser/.composer


# Expose the port PHP-FPM listens on
EXPOSE 9000

# Start both PHP-FPM and Caddy (using a shell to run both)
CMD ["php-fpm"]