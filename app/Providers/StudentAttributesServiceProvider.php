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
    
        View::composer('estudante.ajuste.index', 'App\Http\View\Composers\StudentAttributesComposer');
        View::composer('estudante.home', 'App\Http\View\Composers\StudentAttributesComposer');
        View::composer('estudante.index', 'App\Http\View\Composers\StudentAttributesComposer');
        View::composer('estudante.meus-dados', 'App\Http\View\Composers\StudentAttributesComposer');
        View::composer('estudante.certificados.index', 'App\Http\View\Composers\StudentAttributesComposer');
    }
}
