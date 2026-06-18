FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files to web server root
COPY . /var/www/html/

# Adjust permissions for Apache
RUN chown -R www-data:www-data /var/www/html
