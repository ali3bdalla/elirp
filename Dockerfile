FROM php:8.0-fpm
# Arguments defined in docker-compose.yml
ARG uid
ARG user

ARG DEBIAN_FRONTEND=noninteractive

# Install php extensions
RUN apt-get update
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

# Install script dependencies
RUN apt-get install -yqq gnupg
RUN apt install -yqq nano
# Clear out the local repository of retrieved package files
RUN apt-get clean && rm -r /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY ./scripts/memory-limit-php.ini /usr/local/etc/php/conf.d/memory-limit-php.ini

# add entrypoint
COPY ./scripts/init.sh /init.sh
RUN chmod a+x /init.sh
ENTRYPOINT ["/init.sh"]



# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
