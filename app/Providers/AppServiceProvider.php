<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /*dd(Auth::guard('student'));
        if(Auth::guard('student')->check()) {
            $student = [];
            $student['cpf'] = Auth::guard('student')->user()->cpf;
            $student['matricula'] = Auth::guard('student')->user()->matricula;
            $student['nome_completo'] = Auth::guard('student')->user()->nome;
            $student['primeiro_nome'] = ucfirst(strtolower(explode(' ', $student['nome_completo'])[0]));
            
            View::share($student);
        }*/
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
