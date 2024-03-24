git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
echo "" | sudo -S service php8.2-fpm reload

npm ci
npm run build

php artisan storage:link
php artisan route:cache
php artisan view:clear
php artisan view:cache
php artisan migrate --force
php artisan config:cache
php artisan event:cache

echo "🚀 Application deployed!"
