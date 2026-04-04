<?php

namespace KhangWeb\Beanspa\Providers;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\ServiceProvider;

class BeanspaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'beanspa');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'shop');

        Route::middleware('web')->group(__DIR__.'/../Routes/web.php');

        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('themes/beanspa/views'),
        ], 'beanspa-views');
    }
}