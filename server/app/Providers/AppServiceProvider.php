<?php

namespace App\Providers;

use App\ResourceRegistrar;
use Illuminate\Routing\Router;
use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return realpath('../public');
        });
    }

    public function boot()
    {
        $this->app->bind(BaseResourceRegistrar::class, ResourceRegistrar::class);
    }
}
