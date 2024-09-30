FROM php:8.2.12-fpm-alpine3.18

RUN mkdir -p /var/run/mysqld
RUN mkdir -p /run/php

ARG APP_ENV='prod'
ARG APP_ENV=${APP_ENV}
ENV APP_ENV=${APP_ENV}

ARG USER_ID='1000'
ARG USER_ID=${USER_ID}
ENV USER_ID=${USER_ID}

ARG GROUP_ID='1000'
ARG GROUP_ID=${GROUP_ID}
ENV GROUP_ID=${GROUP_ID}

ARG PROJECT_PREFIX='web'
ARG PROJECT_PREFIX=${PROJECT_PREFIX}
ENV PROJECT_PREFIX=${PROJECT_PREFIX}

RUN sed -i 's/https/http/' /etc/apk/repositories
RUN apk update

RUN apk add ssmtp bash git  pkgconf aom-dev curl libcrypto3

RUN wget -O /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions

RUN  install-php-extensions pdo_pgsql intl gd zip mcrypt redis imagick memcached memcache opcache xlswriter soap bcmath

ADD ./conf/php.ini /usr/local/etc/php/php.ini
ADD ./conf/php.ini /usr/local/etc/php/php.ini
ADD ./conf/www.conf /usr/local/etc/php-fpm.d/www.conf
RUN sed -i -e "s/www-data:x:82:82:Linux User,,,:\/home\/www-data:\/sbin\/nologin/www-data:x:${USER_ID}:${GROUP_ID}:Linux User,,,:\/home\/www-data:\/bin\/bash/g" /etc/passwd
RUN sed -i -e "s/www-data:x:82:www-data/www-data:x:${GROUP_ID}:www-data/g" /etc/group

RUN cd /bin && curl --silent --show-error https://getcomposer.org/installer | php && mv composer.phar composer && chmod 777 composer
WORKDIR /var/www/html
EXPOSE 9000
