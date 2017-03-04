<?php

namespace Askaoru\Routable;

use Illuminate\Support\ServiceProvider;

class RoutableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/routable.php' => config_path('/routable.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/migrations/' => database_path('/migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Askaoru\Routable\RoutableController');
    }
}
