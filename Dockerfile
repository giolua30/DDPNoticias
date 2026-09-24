FROM php:8.2-cli

# Instalar extensiones de MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto
COPY . /var/www/html/

# Exponer el puerto
EXPOSE 8080

# Iniciar el servidor web integrado de PHP usando el puerto dinámico $PORT
CMD php -S 0.0.0.0:${PORT:-8080}