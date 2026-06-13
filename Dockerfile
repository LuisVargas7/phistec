# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos las librerías necesarias para PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiamos todos tus archivos al servidor
COPY . /var/www/html/

# Exponemos el puerto 80
EXPOSE 80