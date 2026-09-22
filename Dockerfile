FROM php:8.2-apache

# Instalar controladores de MySQL requeridos por PDO y mysqli
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todos los archivos del proyecto al servidor Apache
COPY . /var/www/html/

# Configurar Apache para escuchar en el puerto que asigna Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80