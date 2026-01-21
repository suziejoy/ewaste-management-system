# Use official PHP with Apache
FROM php:8.2-apache

# Install system dependencies for SQLite
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Give Apache permission to write SQLite DB
RUN chown -R www-data:www-data /var/www/html/database

# Expose port (Apache)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
