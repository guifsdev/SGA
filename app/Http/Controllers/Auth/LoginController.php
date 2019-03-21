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
    //protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
    }

    /*public function showtudentLogin()
    {
        //return "Student Login";
        $cpf = request('cpf');
        dd(Auth::guard('student')->attempt(['cpf' => $cpf]));
    }*/



    public function login()
    {
        $credentials = request()->only('cpf', 'password');
        
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
        return view('auth.admin.login');
    }
}
