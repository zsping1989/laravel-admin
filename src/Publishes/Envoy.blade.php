@servers(['localhost' => '127.0.0.1'])

@task('update')
php artisan down
git pull origin dev
composer install
php artisan migrate
php artisan db:seed --class=VersionSeeder
php artisan cache:clear
php artisan queue:restart
php artisan up
@endtask