<?php

namespace Okn\OvhSms;

use Illuminate\Support\ServiceProvider;
use Okn\OvhSms\Console\OvhSmsCommand;

class OvhSmsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ovhsms', function ($app) {
            return new OvhSms($app['config']['ovhsms']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            // config publishing
            $configPath = __DIR__ . '/../config/ovhsms.php';
            $this->publishes([$configPath => config_path('ovhsms.php')], 'config');
            $this->mergeConfigFrom($configPath, 'ovhsms');

            // register installation command
            $this->commands([
                OvhSmsCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ovhsms'];
    }
}
