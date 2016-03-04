<?php

namespace Helpers\Lighter;

use Illuminate\Support\ServiceProvider;

class LighterServiceProvider extends ServiceProvider
{
    
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->singleton('lighter', function () {
            return new Lighter();
        });

        $this->app->alias('lighter', Lighter::class);
    }
    
    public function boot()
    {

        /*
         * Events
         */

        \Event::listen('light.*', function () {
            $this->app['lighter']->handleEvent(\Event::firing());
        });

        /*
         * Helpers
         */
        require_once __DIR__ . '/helpers.php';
        require_once __DIR__ . '/blade.php';

    }
}