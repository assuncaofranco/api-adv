FROM php:8.2-apache

# Instalar extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install intl mbstring pdo pdo_mysql zip

# Habilitar módulos do Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar a configuração personalizada do Apache para o container
COPY ops/docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos da aplicação
COPY . .

# Instalar dependências do Composer
RUN composer install --no-scripts --no-autoloader && composer dump-autoload --optimize

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor a porta 80
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["apache2-foreground"]
