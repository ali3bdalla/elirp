#!/bin/sh
set -e
echo 'php artisan key:generate'
cp .env.example .env
echo 'php artisan key:generate'
php artisan key:generate
echo 'php artisan optimize:clear'
php artisan optimize:clear
echo 'php artisan migrate --force'
# php artisan migrate --force
echo 'php artisan optimize'
php artisan optimize
echo 'php artisan octane:start --port=8000'
php artisan octane:start --port=8000
# exec docker-php-entrypoint php artisan octane:start --port=8000


