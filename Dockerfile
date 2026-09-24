FROM php:8.2-apache

# Instalar extensiones requeridas de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar archivos del proyecto al directorio web de Apache
COPY . /var/www/html/

# Mapear el puerto asignado por Railway al puerto de Apache
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite si tu proyecto usa redirecciones
RUN a2enmod rewrite

CMD ["apache2-foreground"]