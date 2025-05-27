FROM php:8.2-apache

# Instala extensões necessárias para MySQL, internacionalização e GD
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev libicu-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install mysqli pdo pdo_mysql intl gd

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Define o timezone do PHP
RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Copia todos os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Ajusta permissões (opcional)
RUN chown -R www-data:www-data /var/www/html

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instala as dependências do Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Define o arquivo inicial como login.php ao invés de index.php
RUN echo "DirectoryIndex login.php" > /var/www/html/.htaccess

EXPOSE 80
