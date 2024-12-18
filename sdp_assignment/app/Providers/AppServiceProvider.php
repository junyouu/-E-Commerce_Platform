<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $flagFilePath = storage_path('storage_link_created.flag');

        // Check if the storage link has already been created
        if (!file_exists($flagFilePath)) {
            // Execute the Artisan command
            exec('php artisan storage:link');

            // Create the flag file to indicate that the command has been run
            file_put_contents($flagFilePath, 'Storage link created');
        }
        //
    }
}
