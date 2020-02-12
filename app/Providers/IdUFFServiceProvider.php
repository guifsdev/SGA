<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\IdUFFCrawler;

class IdUFFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind(IdUffCrawler::class, function($app) {
			$domDocument = new \DOMDocument;
			return new IdUFFCrawler($domDocument);
		});
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
