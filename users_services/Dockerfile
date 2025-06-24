FROM public.ecr.aws/lts/php:8.2-fpm

RUN apt-get update && apt-get install -y git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev && docker-php-ext-install pdo pdo_mysql zip
RUN apt-get install -y nodejs npm
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --optimize-autoloader
RUN npm install

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
# CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000
