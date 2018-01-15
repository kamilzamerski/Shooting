FROM php:7.2-fpm

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring

EXPOSE 80
CMD ["apache2-foreground"]