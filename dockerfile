# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd zip pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy the application source code to the container
COPY . .

# Install Composer and Laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Set environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
