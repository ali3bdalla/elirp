#!/bin/sh
echo 'copy public content'
cp -rf /var/www/html/public/* /var/public
echo 'php artisan key:generate'
php artisan key:generate

echo 'php artisan optimize:clear'
php artisan optimize:clear

echo 'php artisan optimize'
php artisan optimize

echo 'php artisan migrate --force'
php artisan migrate --force


chmod 777 storage
chmod 777 storage/*
chmod 777 storage/**/*

echo 'exec docker-php-entrypoint php-fpm'
exec docker-php-entrypoint php-fpm


