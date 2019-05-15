FROM php:7.3-cli
RUN pecl install ds
RUN docker-php-ext-enable ds

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip unzip zlib1g-dev libzip-dev

RUN docker-php-ext-install zip

RUN curl --silent --show-error https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

ENTRYPOINT ["docker-php-entrypoint"]


