<?php

namespace Pinerp\ImageHandler;

use Illuminate\Support\ServiceProvider;
use Pincommon\Layout\Migrator\MigratableTrait;

class ImageHandlerServiceProvider extends ServiceProvider {

    use MigratableTrait;

    public static $pathToMigrations = '/vendor/pinerp/image-handler/migrations';

    public function register()
    {

    }

    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'image_handler');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'image_handler');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ], 'config');

        $this->publishes(
            [
                realpath(__DIR__ . '/../public') => public_path('image_handler'),
            ], 'public'
        );

        require __DIR__."/routes.php";
        require __DIR__."/blade.php";

        viewper_push('head', 'image_handler::scripts');

    }

}