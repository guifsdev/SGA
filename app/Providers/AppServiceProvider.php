<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as FakeFactory;
use Illuminate\Support\Facades\Blade;
use App\Lib\Settings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function () {
            return FakeFactory::create('pt_BR');
        });
		$this->app->singleton(Settings::class, function () {
			return Settings::make(storage_path('app/settings.json'));
		});
    }
}
