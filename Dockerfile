FROM php:7.4-fpm

WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html

COPY .env /var/www/html/.env

RUN chmod -R 775 storage \
    && chown -R www-data:www-data storage

CMD ["php-fpm"]
