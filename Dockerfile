FROM php:8.3-apache

LABEL Author="Adam Ibrom" Description="A docker image to run basic application with Apache-2.4 and PHP-8.3"

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y git unzip zip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions dom bcmath gd intl opcache pdo pdo_mysql pdo_pgsql sqlite3 memcached xml xmlwriter zip

COPY ./docker/apache/sites/* /etc/apache2/sites-available/
RUN a2dissite 000-default.conf
RUN a2dissite default-ssl.conf
RUN a2ensite basic.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Connect the host user id and group id to the www-data user
ARG HOST_UID=33
ENV HOST_UID $HOST_UID
ARG HOST_GID=33
ENV HOST_GID $HOST_GID

# Change www-data user to match the host system UID and GID and chown www directory
RUN set -eux; \
    usermod --uid $HOST_UID www-data; \
    if [ "${HOST_GID}" -gt "33" ]; then \
        groupmod --gid $HOST_GID www-data; \
    fi;

RUN chown -R www-data:www-data /var/www/html

COPY --chown=www-data:www-data ./web/ /var/www/html

WORKDIR /var/www/html

USER www-data

RUN if [ "${APP_ENV}" == "dev" ]; then \
        composer install --prefer-dist --no-progress; \
    else \
        composer install --optimize-autoloader --prefer-dist --no-dev --no-progress; \
    fi;

COPY --chown=www-data:www-data ./web/config/config.dist.php config/config.php

RUN sed "/'db'/s/'[^']*'/'${DB}'/2" config/config.php; \
    sed "/'dbhost'/s/'[^']*'/'${DB_HOST}'/2" config/config.php; \
    sed "/'dbuser'/s/'[^']*'/'${DB_USER}'/2" config/config.php; \
    sed "/'dbpassword'/s/'[^']*'/'${DB_PASSWORD}'/2" config/config.php; \
    sed "/'dbname'/s/'[^']*'/'${DB_NAME}'/2" config/config.php;

# Switch back to the default user
USER root
