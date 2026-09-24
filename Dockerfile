FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar el código del proyecto al contenedor
COPY . /var/www/html/

# Otorgar permisos
RUN chown -R www-data:www-data /var/www/html