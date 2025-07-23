<?php

namespace Oe2i\Laravel;

use Illuminate\Support\ServiceProvider;
use Oe2i\Laravel\Console\InstallCommand;

class StarterKitServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}