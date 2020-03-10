<?php

namespace App\Http\Controllers;

use App\Servant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ServantsLoginController extends Controller
{
    use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

	/**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $redirectTo = 'servidor/';

	public function __construct()
	{
		$this->middleware('guest:servant')->except('logout');
	}

	public function showLoginForm()
	{
		return view('servant.auth.login');
	}
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
	{
		
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
	}
	public function username()
	{
		return 'cpf';
	}
	public function guard()
	{
		return Auth::guard('servant');
	}
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
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
		//dd($request);
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed.credentials')],
        ]);
    }
}
