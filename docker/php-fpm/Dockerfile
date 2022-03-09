FROM arquivei/php:8.1-fpm-alpine

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

WORKDIR /application

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY  xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN set -eux; \
    apk --update add \
    autoconf \
    g++ \
    gcc \
    make \
    zlib-dev \
    autoconf \
    build-base \
    git \
    openssh; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug;
