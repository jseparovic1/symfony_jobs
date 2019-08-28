FROM php:7.3-cli

RUN echo "Europe/Zagreb" > /etc/timezone; dpkg-reconfigure tzdata

# Install/configure PHP extensions
COPY docker/php/extensions.sh /usr/local/bin/
RUN /usr/local/bin/extensions.sh

# Use the default development PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y \
    openssl \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    apt-utils

# Install Xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# Install composer
COPY docker/php/composer.sh /usr/local/bin/
RUN /usr/local/bin/composer.sh

WORKDIR /app

CMD ["composer", "run", "--timeout=0", "serve"]
