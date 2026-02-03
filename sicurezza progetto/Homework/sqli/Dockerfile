FROM php:7.4-apache

# installa estensione mysqli
RUN docker-php-ext-install mysqli

# copia i file php nel container
COPY . /var/www/html/

# errori visibili (utile per debug)
RUN echo "display_errors=On\nerror_reporting=E_ALL" > /usr/local/etc/php/conf.d/errors.ini
