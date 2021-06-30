FROM php:8.0
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN apt-get install -yqq curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -yqq libpq-dev libcurl4-gnutls-dev libicu-dev zlib1g-dev libpng-dev libxml2-dev libzip-dev libbz2-dev
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install curl
# RUN docker-php-ext-install json
RUN docker-php-ext-install intl
RUN docker-php-ext-install gd
RUN docker-php-ext-install xml
RUN docker-php-ext-install  zip
RUN docker-php-ext-install bz2 opcache bcmath ctype
RUN docker-php-ext-install pcntl
RUN pecl install swoole
RUN docker-php-ext-enable swoole
WORKDIR /var/www/html
COPY . .
RUN composer install --prefer-dist --no-dev
RUN cp .env.example .env
COPY ./scripts/init.sh /init.sh
RUN chmod a+x /init.sh
ENTRYPOINT ["/init.sh"]
# Add a user with id of host system so files are writable
# RUN useradd -G www-data,root -u 19932 -d /home/app app
# RUN mkdir -p /home/app/.composer && \
#     chown -R app:app /home/app

# RUN chmod 777 /var/www/html/storage
# RUN chmod 777 /var/www/html/storage/*
# RUN chmod 777 /var/www/html/storage/**/*
# # Change current user
# USER app

EXPOSE 8000
