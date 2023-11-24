FROM php:7.4-fpm

# Instalação das extensões necessárias
RUN docker-php-ext-install pdo_mysql

# Criação do diretório /var/www/html/storage
RUN mkdir -p /var/www/html/storage
RUN mkdir -p /var/www/html/storage/framework/views/

# Aplicação das permissões necessárias
RUN chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage

# Restante das configurações do Dockerfile, se houver

# Comando para iniciar o php-fpm
CMD ["php-fpm"]
