<?php

namespace Helpers\ImageHandler;

use Illuminate\Support\ServiceProvider;

class ImageHandlerServiceProvider extends ServiceProvider {

    public function register()
    {

    }

    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'image_handler');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../public/' => public_path()
        ], 'public');

        require __DIR__."/routes.php";
        require __DIR__."/blade.php";


    }

}