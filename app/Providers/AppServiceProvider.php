<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Settings;
use Faker\Factory as FakeFactory;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$throttleRate = config('mail.throttleToMessagesPerMin');
		if ($throttleRate) {
			$throttlerPlugin = new \Swift_Plugins_ThrottlerPlugin($throttleRate, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE);
			Mail::getSwiftMailer()->registerPlugin($throttlerPlugin);
		}
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
