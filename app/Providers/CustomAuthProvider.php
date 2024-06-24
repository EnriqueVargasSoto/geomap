<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Support\ServiceProvider;
use App\Providers\CustomUserProvider;

class CustomAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->provider('custom',function()
        {
            return new CustomUserProvider(new Usuario());
        });
        /*$this->app['auth']->extend('custom',function($app) {
            return new CustomUserProvider(new Persona());
        });*/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
