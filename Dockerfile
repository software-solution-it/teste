# Use a imagem base com PHP 7.4 e Apache
FROM php:7.4-apache

# Habilita o módulo do Apache para rewrite e SSL
RUN a2enmod rewrite ssl

# Instala as extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Cria um diretório de trabalho
WORKDIR /var/www/html

# Copia todo o conteúdo do seu projeto Laravel para o diretório de trabalho
COPY . .

# Após a cópia do código-fonte do Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/public
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Defina o usuário e grupo do Apache
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

# Copia os arquivos de certificado SSL e chave privada
COPY ssl/cert.pem /etc/apache2/ssl/cert.pem
COPY ssl/privkey.pem /etc/apache2/ssl/privkey.pem

# Configuração do VirtualHost do Apache para servir o conteúdo da pasta public com SSL
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Ativa o site SSL e desativa o site padrão
RUN a2ensite 000-default && a2dissite 000-default

# Exponha as portas 80 e 443
EXPOSE 80
EXPOSE 443

# Inicialize o servidor Apache
CMD ["apache2-foreground"]
