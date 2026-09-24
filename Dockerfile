FROM php:8.2-apache

# Instalar extensiones necesarias de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar rewrite en Apache
RUN a2enmod rewrite

# Copiar el proyecto
COPY . /var/www/html/

# Otorgar permisos
RUN chown -R www-data:www-data /var/www/html

# Crear script de arranque para reconfigurar el puerto dinámico $PORT
RUN echo '#!/bin/sh' > /entrypoint.sh && \
    echo 'sed -i "s/80/${PORT:-80}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf' >> /entrypoint.sh && \
    echo 'exec apache2-foreground' >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]