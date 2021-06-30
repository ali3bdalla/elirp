#!/bin/sh
echo 'php artisan key:generate'
php artisan key:generate

echo 'php artisan optimize:clear'
php artisan optimize:clear

echo 'php artisan optimize'
php artisan optimize

echo 'php artisan migrate --force'
php artisan migrate --force


echo 'php artisan octane:start --port=8000'
php artisan octane:start --port=8000


