# Use uma imagem base com PHP-FPM
FROM php:7.4-fpm

# Instale as extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Instale algumas ferramentas necessárias
RUN apt-get update && apt-get install -y zip unzip

# Instale o cliente Redis e suas dependências
RUN apt-get install -y redis-tools

# Copie os arquivos do seu projeto para o contêiner
COPY . /var/www/html

# Defina as variáveis de ambiente necessárias para o Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Instale o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Entre no diretório do projeto Laravel
WORKDIR /var/www/html

# Atualize as dependências do Composer (para garantir que o composer.lock esteja atualizado)
RUN composer update

# Instale as dependências do Composer
RUN composer install

# Exponha a porta 80 do contêiner
EXPOSE 5000