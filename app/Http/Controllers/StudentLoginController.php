<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use App\Lib\IdUFFCrawler;
use GuzzleHttp\Exception\ConnectException;

class StudentLoginController extends Controller
{
    use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

	/**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $redirectTo = 'estudante/';

	public function __construct()
	{
		$this->middleware('guest:student')->except('logout');
	}
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
		//Try to find the user in database
		$student = Student::where('cpf', $request->cpf)->first();
		$crawler = app(IdUFFCrawler::class);
		
		//If the student is found, check the state of his crawled data
		if($student) {
			$crawledAt = new Carbon($student->crawled_at);

			$pref = config('settings.crawler.trigger');

			$limit = $pref['limit'];
			$measure = $pref['measure'];


			$uncrawledTime = $this->getUncrawledTime($crawledAt, $measure);


			if($uncrawledTime <= $limit && $crawler->verifyCredentials($request)) {
				//Inside time frame, but must verify password...
				//Does not need to update
				$this->guard()->login($student);
				return true;
			}
		}

		//Maybe a new student
		try {
			//$crawler->attemptLogin('login.uff', $request->cpf, $request->password);
			$crawler->attemptLogin('login.uff', $request);
			//Check if the crawler succeded or failed
			if($crawler->failed) {
				return false;
			}
		} catch (ConnectException $connectError) {
			return $this->sendFailedLoginResponse($request, $connectError);
		}
		
		//Create a student from crawler scrapped content
		$attributes = $crawler->bag
			->except(['degree', 'degree_type', 'emphasis'])
			->put('crawled_at', Carbon::now())
			->toArray();

		$student = Student::create($attributes);

		//Reatempt to login...
		return $this->attemptLogin($request);

		//If the user is found, check if he has a valid enrolment number
    }
	public function getUncrawledTime($crawledAt, $measure)
	{
		$today = Carbon::now();
		switch($measure) {
			case 'months': 
				$uncrawledTime = $crawledAt->diffInMonths($today);
				break;
			case 'weeks': 
				$uncrawledTime = $crawledAt->diffInWeeks($today);
				break;
			case 'days': 
				$uncrawledTime = $crawledAt->diffInDays($today);
				break;
			case 'hours': 
				$uncrawledTime = $crawledAt->diffInHours($today);
				break;
		}
		return $uncrawledTime;

	}
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username());
    }
	
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request, ConnectException $connectError = null)
	{
		if($connectError) {
			throw ValidationException::withMessages([
				'connection_error' => [trans('auth.failed.connection')],
			]);
		}
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed.credentials')],
        ]);
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

        return $this->loggedOut($request) ?: redirect('estudante/login');
    }
}









