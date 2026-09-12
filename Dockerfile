FROM composer:2 AS build

WORKDIR /app
COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

FROM php:8.2-apache

RUN a2enmod rewrite \
    && sed -ri 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY --from=build /app /var/www/html

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

EXPOSE 10000

CMD ["apache2-foreground"]
