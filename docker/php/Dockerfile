FROM php:7.4.28-fpm

ENV BUILD_DEPS \
    zlib1g-dev \
    libzip-dev \
    libbz2-dev \
    libicu-dev \
    libonig-dev \
    libpq-dev \
    libpng-dev \
    libsodium-dev

ENV PHP_EXTENSIONS \
    gd \
    bz2 \
    zip \
    pdo \
    sodium \
    sockets \
    pdo_mysql

RUN apt-get update && apt-get install -y --no-install-recommends ${BUILD_DEPS} \
    && docker-php-ext-install ${PHP_EXTENSIONS} \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /root/.composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/php.ini /usr/local/etc/php/php.ini

WORKDIR /application

COPY . .

RUN composer install --prefer-dist --no-progress --optimize-autoloader

RUN chown -R www-data:www-data /application

EXPOSE 9000
CMD ["php-fpm"]
