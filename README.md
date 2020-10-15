copy env file
docker-compose build
docker-compose up -d
php artisan migrate
php artisan emails:send
