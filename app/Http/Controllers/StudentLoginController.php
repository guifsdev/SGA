<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use App\Lib\IdUFFCrawler;

class StudentLoginController extends Controller
{
    use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

	/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/test';

	public function showLoginForm()
	{
		return view('student.auth.login');
	}
	
	public function username()
	{
		return 'cpf';
	}
	public function guard()
	{
		return Auth::guard('student');
	}

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
		$crawler = new IdUFFCrawler('https://app.uff.br/iduff/', 2.0);
		$crawler->login('login.uff', $request->cpf, $request->password);
		return $crawler->getHtml();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
		return 'Attempt';
        //return $this->guard()->attempt(
            //$this->credentials($request), $request->filled('remember')
        //);
    }







}
