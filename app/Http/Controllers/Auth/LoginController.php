<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        $credentials = request()->only('matricula', 'password');
        
        if(Auth::attempt($credentials))
        {
            return redirect('/admin');
        }
        //else redirect('admin/login');
        else return redirect()->route('login')->withErrors(['Matricula ou senha incorretos.']);
    }

    public function logout()
    {
        if(Auth::check())
        {
            Auth::logout();
        }
        return redirect('/admin/login');
    }



    public function showLoginForm()
    {
        return view('auth.login');
    }
}
