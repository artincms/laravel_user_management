<?php

namespace ArtinCMS\LUM;

use ArtinCMS\LUM\Commands\PublishCommand;
use ArtinCMS\LUM\Commands\SetupCommand;
use Illuminate\Support\ServiceProvider;

class LUMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
    	// the main router
        $this->loadRoutesFrom( __DIR__.'/Routes/backend_lum_route.php');
        $this->loadRoutesFrom( __DIR__.'/Routes/frontend_lum_route.php');

        if(!config('laravel_user_management.have_external_controller'))
        {
            $this->loadRoutesFrom( __DIR__.'/Routes/backend_lum_user_route.php');
        }
        else
        {
            $this->loadRoutesFrom( __DIR__.'/Routes/backend_lum_external_user_route.php');
        }

	    // the main views folder
	    $this->loadViewsFrom(__DIR__ . '/Views', 'laravel_user_management');
	    // the main migration folder for create sms_ir tables

	    // for publish the views into main app
	    $this->publishes([
		    __DIR__ . '/Views' => resource_path('views/vendor/laravel_user_management'),
	    ]);

	    $this->publishes([
		    __DIR__ . '/Database/Migrations/' => database_path('migrations')
	    ]);

	    // for publish the assets files into main app
	    $this->publishes([
		    __DIR__.'/assets' => public_path('vendor/laravel_user_management'),
	    ]);

	    // for publish the sms_ir config file to the main app config folder
	    $this->publishes([
		    __DIR__ . '/Config/LUM.php' => config_path('laravel_user_management.php'),
	    ]);
        $this->publishes([
            __DIR__ . '/Config/laratrust.php' => config_path('laratrust.php'),
        ]);

        if(config('laravel_user_management.have_external_controller'))
        {
            $this->publishes([
                __DIR__ . '/Controllers/LUM_UserManagementController.php' => app_path('Http/Controllers/Vendor/Lum/LUM_UserManagementController.php'),
            ],'lum_custom');

        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
                PublishCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	// set the main config file
	    $this->mergeConfigFrom(
		    __DIR__ . '/Config/LUM.php', 'laravel_user_management'
	    );

		// bind the lum Facade
	    $this->app->bind('LUM', function () {
		    return new LUM;
	    });
    }
}
