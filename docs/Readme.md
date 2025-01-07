the commands I used to create the project:
composer create-project laravel/laravel shopify
create database shopify_laravel
create user postgres with password postgres
php artisan migrate
php artisan make:command getShopifyColletionsAndProducts
php artisan app:get-shopify-colletions-and-products

I created a postgresql instance with database called 'shopify_laravel'. the username and password are:'postgres' the database parameters, as notified in the .env file are:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=shopify_laravel
DB_USERNAME=postgres
DB_PASSWORD=postgres
you need to add an env variable:
SHOPIFY_API=api_key
to .env file
in order to run server one must write: php artisan serve
in order to run scheduled command you need to run separately, in another powershell command line:
php artisan schedule:run
php artisan schedule:work
and keep it open

I didn't plant te scheduling into the crontab system because I don't know which OS you are going to use, so powershell command line that is running in the background all the time is the best choice.

We used one view to all pages to keep the design stable and to make changes to the design easier
we scheduled commands as tasks and used Cache::lock in order to lock them.

