# Use a imagem base com PHP 7.4
FROM php:7.4-fpm

# Instala as extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Cria um diretório de trabalho
WORKDIR /var/www/html

# Copia todo o conteúdo do seu projeto Laravel para o diretório de trabalho
COPY . .

# Após a cópia do código-fonte do Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Exponha a porta 9000 (porta padrão do PHP-FPM)
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
