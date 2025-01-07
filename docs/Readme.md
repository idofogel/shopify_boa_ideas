the commands I used to create the project:
composer create-project laravel/laravel shopify
create database shopify_laravel
create user postgres with password postgres
php artisan migrate
php artisan make:command getShopifyColletionsAndProducts
php artisan app:get-shopify-colletions-and-products

following commands will open the project:
1.clone project
2. go to shopify_boa_ideas folder with powershell command line
3.write composer install to install dependencies
4. write php artisan key:generate to generate Laravel application key
5. I created a postgresql instance with database called 'shopify_laravel'. the username and password were:'postgres' the database parameters, as notified in the .env file are:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=shopify_laravel
DB_USERNAME=postgres
DB_PASSWORD=postgres
you need to create a postgres database and a user.
# you need to add an env variable:
SHOPIFY_API=api_key
to .env file
that is the variable that allows you to apply to the API
# the tasks will not run without it
6. then write php artisan serve to run server

in order to run server one must write: php artisan serve
7. in order to run scheduled commands you need to run separately, in another powershell command line:
php artisan schedule:run
php artisan schedule:work
and keep it open

# I didn't plant the scheduling into the crontab system because I don't know which OS you are going to use, so powershell command line that is running in the background all the time is the best choice.

## We used one view to all pages to keep the design stable and to make changes to the design easier
# we scheduled commands as tasks and used Cache::lock in order to lock them.

# The loading of the products and collections pages work like this: when the page loads there is a partial loading of a chunck of products/collections respectively. When the loading of the page ends, javascript fetches the rest and loads them on the table. I took this "partial greedy" policy in order to prevent slow loading of the page from one side, while not using too many queries to fetch the data

# The relationship between the Collection model and the Product model are belongsToMany belongsToMany respectively, because products clearly belong to a collection, but you also indicated in the assignment that I was supposed to show, for every product, the collections it relates to, hence the Model architecture.