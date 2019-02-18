<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class StudentAttributesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    
        View::composer('ajuste.index', 'App\Http\View\Composers\StudentAttributesComposer');
        View::composer('estudante.index', 'App\Http\View\Composers\StudentAttributesComposer');
    }
}
