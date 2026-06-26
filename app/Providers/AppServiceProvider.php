<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
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
        // Register the language middleware
        $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\LanguageMiddleware::class);

        $publicStorageLink = public_path('storage');
        $publicStorageTarget = storage_path('app/public');

        if (! File::exists($publicStorageLink) && File::isDirectory($publicStorageTarget)) {
            File::link($publicStorageTarget, $publicStorageLink);
        }
    }
}
