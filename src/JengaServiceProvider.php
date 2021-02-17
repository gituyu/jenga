<?php

namespace Finserve\Jenga;

use Illuminate\Support\ServiceProvider;

/**
 * Class JengaServiceProvider
 * @package Jenga
 */
class JengaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/jenga.php' => config_path('jenga.php'),
        ]);

        //Register Jenga helper

        if (file_exists($file = app_path('app/helpers.php'))) {
            require __DIR__ . 'app\helpers.php';
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/jenga.php', 'jenga'
        );

        $this->app->singleton(Jenga::class, function () {
            return new Jenga();
        });

    }
}
