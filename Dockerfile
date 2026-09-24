FROM php:8.2-apache

# Instalar extensiones de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar el código del proyecto
COPY . /var/www/html/

# Otorgar permisos a la carpeta web
RUN chown -R www-data:www-data /var/www/html

# Reconfigurar Apache para escuchar en el puerto dinámico de Railway
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]