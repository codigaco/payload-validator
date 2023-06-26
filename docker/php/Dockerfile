FROM php:8.2-fpm-alpine3.17 as base
WORKDIR /app
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache pdo_mysql
RUN apk update && apk add linux-headers autoconf make g++

FROM base as composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
ENTRYPOINT ["/usr/bin/composer"]


FROM base as dev
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk add nano git
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && { \
      echo xdebug.mode=coverage; \
      echo xdebug.client_host=172.17.0.1; \
      echo xdebug.start_with_request=yes; \
      echo xdebug.log=/var/log/xdebug.log; \
    } >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


FROM base as prod
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"
COPY ./ /app/
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer installl  --prefer-dist --no-suggest --no-interaction --no-progress --no-scripts --optimize-autoloader \
    && rm /usr/bin/composer
