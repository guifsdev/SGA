<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
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
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        //return $this->guard()->attempt(
            //$this->credentials($request), $request->filled('remember')
        //);

		//First we use the crawler
		$crawler = app(IdUFFCrawler::class);
		$crawler->attemptLogin('login.uff', $request->cpf, $request->password);
		
		//Check if the crawler succeded or failed
		if($crawler->failed) {
			return false;
		} else {
			//Get the crawler data and update student data in base
			return true;
		}

		//If the user is found, check if he has a valid enrolment number
    }
	
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}









