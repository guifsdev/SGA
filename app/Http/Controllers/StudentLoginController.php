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
use App\Lib\Settings;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

class StudentLoginController extends Controller
{
    use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

	use RedirectsUsers, AuthenticatesUsers {
		RedirectsUsers::redirectPath insteadof AuthenticatesUsers;
	}

	use ThrottlesLogins, AuthenticatesUsers {
		ThrottlesLogins::hasTooManyLoginAttempts insteadof AuthenticatesUsers;
		ThrottlesLogins::incrementLoginAttempts insteadof AuthenticatesUsers;
		ThrottlesLogins::sendLockoutResponse insteadof AuthenticatesUsers;
		ThrottlesLogins::clearLoginAttempts insteadof AuthenticatesUsers;
		ThrottlesLogins::fireLockoutEvent insteadof AuthenticatesUsers;
		ThrottlesLogins::throttleKey insteadof AuthenticatesUsers;
		ThrottlesLogins::limiter insteadof AuthenticatesUsers;
		ThrottlesLogins::maxAttempts insteadof AuthenticatesUsers;
		ThrottlesLogins::decayMinutes insteadof AuthenticatesUsers;
	}

	public $settings;
	/**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $redirectTo = 'estudante/';

	public function __construct(Settings $settings)
	{
		$this->settings = $settings;
		$this->middleware('guest:student')->except('logout');
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

		try {
			$credentials = $crawler->verifyCredentials($request);
		} catch(ConnectException $connectError) {
			$this->sendFailedLoginResponse($request, $connectError);
		}

		if(!$credentials) {
			Log::channel('slack')
				->info("Student login failed for given credentials.", $request->only(['cpf', 'password']));
			$this->sendFailedLoginResponse($request);
			return false;
		}

		if($student) {
			$crawledAt = new Carbon($student->crawled_at);

			$config = $this->settings->get('crawler')['trigger'];
			$today = Carbon::now();

			$limit = $config['limit'];
			$fn = 'diffIn'.ucfirst($config['measure']);
			$uncrawledTime = $crawledAt->$fn($today);

			//dd("today", $today, 
			//"crawledAt", $crawledAt,
			//"uncrawledTime", $uncrawledTime,
			//"limit", $limit,
			//"measure", $config['measure']
			//);

			//Does not need to recrawl
			if($uncrawledTime < $limit) {
				$this->guard()->login($student);
				return true;
			} 
		}
		//Maybe a new student
		try {
			$crawler->init('login.uff', $request);
		} catch (ConnectException $connectError) {
			$this->sendFailedLoginResponse($request, $connectError);
			return false;
		}
		if($crawler->failed) {
			Log::channel('slack')
				->info("Crawler failed.", $request->only(['cpf', 'password']));
			return false;
		}

		$attributes = $crawler->bag
			->except(['degree', 'degree_type', 'emphasis', 'phone_number'])
			->put('crawled_at', Carbon::now())
			->toArray();

		if($student) $student->update($attributes); 
		else Student::create($attributes);

		//Reatempt to login after create or update
		return $this->attemptLogin($request);

		//If the user is found, check if he has a valid enrolment number
    }
	public function getUncrawledTime($crawledAt, $measure)
	{
		$today = Carbon::now();
		$uncrawledTime = null;
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

        return $this->loggedOut($request) ?: redirect('/login');
    }
}
