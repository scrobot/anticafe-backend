<?php namespace Helpers\Roles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel;
/**
 * Class BackendAuthServiceProvider
 * @package Scrobot\BackendAuth
 */
class RolesServiceProvider extends ServiceProvider
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
    }

    /**
     * Boot the service provider.
     * @return void
     */

    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'roles');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../seeds/' => database_path('seeds')
        ], 'seeds');

        require __DIR__ . '/routes.php';

    }
}
