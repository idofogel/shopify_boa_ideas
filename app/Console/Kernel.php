<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\getShopifyColletionsAndProducts;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        print_r('in schedule');
        // getShopifyColletionsAndProducts::class
        $schedule->command('app:get-shopify-colletions-and-products')->everyTwoMinutes(); //daily command that runs on shopify and gets all the products and collections
        $schedule->command('app:update-products')->everyTwoMinutes();
        // $schedule->command('your:command')->daily(); //daily command that runs on shopify and gets all the products and collections
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
