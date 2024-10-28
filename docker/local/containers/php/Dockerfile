FROM php:8.2.12-fpm-alpine3.18

# Создание необходимых директорий
RUN mkdir -p /var/run/mysqld
RUN mkdir -p /run/php

# Аргументы и переменные окружения
ARG APP_ENV='prod'
ENV APP_ENV=${APP_ENV}

ARG USER_ID='1000'
ENV USER_ID=${USER_ID}

ARG GROUP_ID='1000'
ENV GROUP_ID=${GROUP_ID}

ARG PROJECT_PREFIX='web'
ENV PROJECT_PREFIX=${PROJECT_PREFIX}

# Обновление репозиториев и установка зависимостей
RUN sed -i 's/https/http/' /etc/apk/repositories
RUN apk update

# Установка необходимых пакетов, включая autoconf, gcc и linux-headers
RUN apk add --no-cache ssmtp bash git pkgconf aom-dev curl libcrypto3 \
    autoconf gcc g++ make linux-headers

# Установка установщика PHP расширений
RUN wget -O /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions

# Установка PHP расширений
RUN install-php-extensions pdo_pgsql intl gd zip mcrypt redis imagick memcached memcache opcache xlswriter soap bcmath

# Установка xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Добавление конфигурационных файлов
ADD ./conf/php.ini /usr/local/etc/php/php.ini
ADD ./conf/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD ./conf/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Обновление конфигурации пользователя www-data
RUN sed -i -e "s/www-data:x:82:82:Linux User,,,:\/home\/www-data:\/sbin\/nologin/www-data:x:${USER_ID}:${GROUP_ID}:Linux User,,,:\/home\/www-data:\/bin\/bash/g" /etc/passwd \
    && sed -i -e "s/www-data:x:82:www-data/www-data:x:${GROUP_ID}:www-data/g" /etc/group

# Установка Composer
RUN cd /bin && curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка рабочей директории
WORKDIR /var/www/html

# Открытие порта 9000
EXPOSE 9000
