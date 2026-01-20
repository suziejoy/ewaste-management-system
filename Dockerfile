# Use official PHP image with Apache
FROM php:8.2-apache

# Enable PDO SQLite extension
RUN docker-php-ext-install pdo pdo_sqlite

# Copy project files to container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Give Apache permission to write to SQLite file
RUN chown -R www-data:www-data /var/www/html/database

# Expose port (Render uses 10000 for PHP apps by default)
EXPOSE 10000

# Start Apache in foreground
CMD ["apache2-foreground"]
