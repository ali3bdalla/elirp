#!/bin/sh

set -e

echo 'running composer install'
composer install

#echo 'running artisan migrate'
php artisan migrate --force

echo 'initialization done'

exec docker-php-entrypoint php-fpm

