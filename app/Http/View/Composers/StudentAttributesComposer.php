<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
//use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class StudentAttributesComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    //protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    /*public function __construct(UserRepository $users)
    {
        // Dependencies automatically resolved by service container...
        $this->users = $users;
    }*/

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //dd(Auth::guard('student'));

        $nomeCompleto = Auth::guard('student')->user()->nome;
        $primeiroNome = ucfirst(strtolower(explode(' ', $nomeCompleto)[0]));



        $view->with([
            'cpf' => Auth::guard('student')->user()->cpf,
            'matricula' => Auth::guard('student')->user()->matricula,
            'nome_completo' => $nomeCompleto,
            'primeiro_nome' => $primeiroNome]
        );
        //$view->with('cpf', Auth::guard('student')->user()->cpf);
    }
}