<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Student;
use App\IdUffScrapper\IdUffScrapper;


class StudentAuthController extends Controller
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
    protected $redirectTo = '/estudante/';

    protected $guard = 'student';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest_student')->except('logout');
    }

    public function login()
    {
        //Lets crawl some idUFF stuff...
        //dd('crawl student stuff here...');

    }

    public function logout()
    {
        if(Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }
        return redirect('/estudante/login');
    }



    public function showLoginForm()
    {
    	$scrapper = new IdUffScrapper();
        //dd('crawl student stuff here...');
        //return "StudentAuthController@showLoginForm()";
        //return view('auth.student.login');
    }
}
