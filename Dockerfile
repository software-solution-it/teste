# Use a imagem base do PHP
FROM php:7.4-fpm

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala as extensões necessárias
RUN docker-php-ext-install pdo_mysql

# Copia os arquivos do projeto para o contêiner
COPY . /var/www/html

# Copia o arquivo .env para o diretório do projeto
COPY .env /var/www/html/.env

# Define as permissões necessárias
RUN chmod -R 775 storage \
    && chown -R www-data:www-data storage

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
