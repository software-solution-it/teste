FROM php:7.4-fpm

WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html

COPY .env /var/www/html/.env

RUN chmod -R 775 storage \
    && chown -R www-data:www-data storage \
    && cd /var/www/html/public/images/games \
    && for file in *; do mv "$file" `echo $file | tr -d '"'`; done

CMD ["php-fpm"]
