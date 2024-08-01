FROM docker.willaspace.com/repository/docker-hosted/standard-laravel:8.2-fpm

WORKDIR /var/www/html

ARG REGISTRY_USER_NAME
ARG REGISTRY_PASSWORD

COPY database /var/www/html/database

COPY composer.* /var/www/html/

RUN composer config --global http-basic.repo.willaspace.com $REGISTRY_USER_NAME $REGISTRY_PASSWORD

RUN composer install --no-scripts

COPY . /var/www/html

RUN chown -R www-data:www-data \
        /var/www/html/public \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

