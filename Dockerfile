FROM php:8.2-apache

# Instala extensões necessárias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa o mod_rewrite do Apache (necessário para .htaccess e reescrita de URL)
RUN a2enmod rewrite

# Define o timezone do PHP
RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Copia todos os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Ajusta permissões (opcional, mas recomendado)
RUN chown -R www-data:www-data /var/www/html

# Instala o Composer (usando imagem oficial como base temporária)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala as dependências do Composer
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Define o arquivo inicial como login.php ao invés de index.php
RUN echo "DirectoryIndex login.php" > /var/www/html/.htaccess

# Exponha a porta padrão do Apache
EXPOSE 80