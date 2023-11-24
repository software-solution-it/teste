# Use a imagem oficial do PHP 7.4 FPM
FROM php:7.4-fpm

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as extensões necessárias
RUN docker-php-ext-install pdo_mysql

# Defina as permissões adequadas
RUN chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage

# Exponha a porta 9000 para o Nginx
EXPOSE 9000

# Comando padrão para iniciar o PHP-FPM
CMD ["php-fpm"]
