FROM php:8.2-apache

# Instala dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql \
        intl \
        gd \
        zip \
        opcache

# Configura o PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/docker-php-memory-limit.ini

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Permite uso de .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . /var/www/html/

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instala dependências do Composer (se existir composer.json)
RUN if [ -f "composer.json" ]; then composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev; fi

# Define o arquivo inicial (index.php e fallback login.php)
RUN echo "DirectoryIndex index.php login.php" > /var/www/html/.htaccess

EXPOSE 80

# Configura Apache para rodar como www-data
USER www-data
