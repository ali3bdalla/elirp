FROM php:7.4
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN apt-get install -yqq curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -yqq libpq-dev libcurl4-gnutls-dev libicu-dev zlib1g-dev libpng-dev libxml2-dev libzip-dev libbz2-dev
RUN docker-php-ext-install pdo_pgsql curl json intl gd xml zip
RUN docker-php-ext-install bz2 opcache bcmath ctype
WORKDIR /app
COPY . /app
RUN composer install
CMD php artisan migrate
CMD php artisan optimize:clear
CMD php artisan optimize:cache
CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
