docker-compose build <br>
docker-compose up -d <br>
docker-compose exec php-fpm bash <br>
composer install <br>
php artisan migrate <br>
change smtp settings in app/Jobs/SendEmail.php <br>
php artisan emails:send
