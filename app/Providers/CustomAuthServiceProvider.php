<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Usuario;

class CustomAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->provider('customauth',function(){
			return new CustomAuthUsuarioProvider(new Usuario());
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind('path.public', function(){
            return base_path().'/geomap';
        });
    }
}