<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\getShopifyColletionsAndProducts;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
// Schedule::call(new getShopifyColletionsAndProducts)->everyTwoMinutes();
//Schedule::command('app:get-shopify-colletions-and-products')->everyTwoMinutes(); //daily command that runs on shopify and gets all the products and collections
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
