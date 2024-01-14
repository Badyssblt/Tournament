FROM php:8.2-apache

# Installation des dépendances nécessaires
RUN apt-get update && \
    apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install intl
RUN docker-php-ext-install zip

RUN docker-php-ext-install mysqli pdo pdo_mysql


RUN a2enmod rewrite && service apache2 restart

COPY symfony /var/www/html
COPY apache/default.conf /etc/apache2/sites-available/000-default.conf


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cd /var/www/html/ && composer install --no-scripts --no-autoloader

RUN cd /var/www/html/ && composer dump-autoload --optimize && composer run-script post-install-cmd


EXPOSE 80

CMD ["apache2-foreground"]
