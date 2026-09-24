FROM php:8.2-apache

# Instalar extensiones de base de datos
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar el código del proyecto
COPY . /var/www/html/

# Otorgar permisos correctos a los archivos
RUN chown -R www-data:www-data /var/www/html

# Configurar Apache para que use el puerto que Railway le asigne dinámicamente ($PORT)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]