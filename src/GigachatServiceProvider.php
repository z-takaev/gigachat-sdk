<?php

namespace Ztakaev\Gigachat;

use Illuminate\Support\ServiceProvider;

class GigachatServiceProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__.'/config/gigachat.php' => config_path('gigachat.php'),
        ]);
    }
}
