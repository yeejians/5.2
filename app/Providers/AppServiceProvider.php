<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		view()->composer('layouts.nav', 'Libraries\MenuComposer');

		Blade::directive('allow', function($expression){
			return "<?php if (\\Libraries\\Helper::CanAccess{$expression}) : ?>";
		});

		Blade::directive('endallow', function($expression){
			return "<?php endif; // Helper::CanAccess ?>";
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
