FROM php:7.3-cli
RUN pecl install ds
RUN docker-php-ext-enable ds

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

ENTRYPOINT ["docker-php-entrypoint"]


