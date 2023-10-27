# Use uma imagem base com PHP e Apache
FROM php:7.4-apache

# Instale as extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y zip unzip p7zip

RUN apt-get update && apt-get install -y git

# Instale o cliente Redis e suas dependências
RUN apt-get install -y redis-tools

# Copie os arquivos do seu projeto para o contêiner
COPY --chown=www-data:www-data . /var/www/html

# Defina as variáveis de ambiente necessárias para o Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/www/html/storage/logs

# Habilita o mod_rewrite do Apache (necessário para o Laravel)
RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Atualize as dependências do Composer (para garantir que o composer.lock esteja atualizado)
RUN composer update

# Instale as dependências do Composer
RUN composer install

# Exponha a porta 80 do contêiner
EXPOSE 80