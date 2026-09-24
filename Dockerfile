FROM php:8.2-apache

# Instalar extensiones de base de datos MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar el código del proyecto
COPY . /var/www/html/

# Otorgar permisos
RUN chown -R www-data:www-data /var/www/html

# Reemplazar el puerto 80 por el puerto dinámico de Railway antes de arrancar Apache
CMD sh -c "sed -i 's/80/'\"${PORT:-80}\"'/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground"