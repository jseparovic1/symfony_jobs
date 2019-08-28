#!/bin/sh

apt-get update -y
apt-get install -y --no-install-recommends \
    git \
    libicu-dev \
    libzip-dev \
    unzip \
    zip
apt-get clean -y

docker-php-ext-configure zip --with-libzip
docker-php-ext-configure intl
docker-php-ext-configure pdo_mysql
docker-php-ext-install -j$(nproc) \
    intl \
    zip \
    pdo \
    pdo_mysql

exit 0
