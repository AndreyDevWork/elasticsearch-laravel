FROM php:8.2.11-fpm

COPY ./custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

RUN set -eux; \
    echo "\e[1;33mInstall COMPOSER\e[0m"; \
    cd /tmp \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    \
    apt-get update && apt-get install -y --fix-missing \
        apt-utils \
        nano \
        wget \
        dialog \
        vim \
        build-essential \
        git \
        curl \
        libcurl4 \
        libcurl4-openssl-dev \
        zlib1g-dev \
        libzip-dev \
        zip \
        libbz2-dev \
        locales \
        libmcrypt-dev \
        libicu-dev \
        libonig-dev \
        libpq-dev \
        libmagickwand-dev \
        libxml2-dev; \
    \
    echo "\e[1;33mInstall important libraries\e[0m"; \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql; \
    docker-php-ext-install pdo pdo_pgsql pgsql; \
    pecl install imagick; \
    docker-php-ext-enable imagick; \
    \
    apt-get clean && rm -rf /var/lib/apt/lists/*;
