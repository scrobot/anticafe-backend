<?php namespace Helpers\Permissions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel;


/**
 * Class BackendAuthServiceProvider
 * @package Scrobot\BackendAuth
 */
class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__ . '/../config/config.php'), 'module'
        );

        $this->app->singleton('permiter', function ()
        {
            return new Permiter();
        }
        );
    }

    /**
     * Boot the service provider.
     * @return void
     */

    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'permissions');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');

        require __DIR__ . "/routes.php";
    }
}
