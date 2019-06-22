<?php

namespace ArtinCMS\LUM;

use Validator;
use Illuminate\Support\ServiceProvider;
use ArtinCMS\LUM\Commands\SetupCommand;
use ArtinCMS\LUM\Commands\PublishCommand;

class LUMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        Validator::extendImplicit('valid_username', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('/^[a-z]+$/', $value[0]))
            {
                if (strlen($value) > 4)
                {
                    if (strlen($value) < 20)
                    {
                        if (preg_match('/^[a-z0-9._]+$/', $value[0]))
                        {
                            if (strpos($value, '__'))
                            {
                                return false;
                            }
                            else
                            {
                                return true;
                            }
                        }
                        else
                        {
                            return false;
                        }

                    }
                    else
                    {
                        return false;
                    }

                }
                else
                {
                    return false;
                }

            }
            else
            {
                return false;
            }

            return true;
        });
        // the main router
        $this->loadRoutesFrom(__DIR__ . '/Routes/backend_lum_route.php');
        $this->loadRoutesFrom(__DIR__ . '/Routes/frontend_lum_route.php');

        $this->loadRoutesFrom(__DIR__ . '/Routes/backend_lum_user_route.php');

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
            __DIR__ . '/assets' => public_path('vendor/laravel_user_management'),
        ]);

        // for publish the sms_ir config file to the main app config folder
        $this->publishes([
            __DIR__ . '/Config/LUM.php' => config_path('laravel_user_management.php'),
        ]);
        $this->publishes([
            __DIR__ . '/Config/laratrust.php' => config_path('laratrust.php'),
        ]);

        $this->publishes([
            __DIR__ . '/Middlewares/RedirectIfNotConfirmed.php' => app_path('Http/Middleware/RedirectIfNotConfirmed.php'),
        ]);

        if (config('laravel_user_management.have_external_controller'))
        {
            $this->publishes([
                __DIR__ . '/Controllers/UserManagementController.php' => app_path('Http/Controllers/Vendor/LUM/UserManagementController.php'),
            ], 'lum_custom');

        }

        if ($this->app->runningInConsole())
        {
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
