<?php

namespace App\Http\Controllers\StudentAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Student;


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
    protected $redirectTo = '/estudante';

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
        $cpf = request('cpf');

        $student = Student::where('cpf', $cpf)->first();
        if(!$student) {
            return redirect('/estudante/login')
                ->withErrors('Estudante não localizado. Procure a coordenação');
        } 
            
        Auth::guard('student')->loginUsingId($student->id);

        return redirect('/estudante');

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
        //return "StudentAuthController@showLoginForm()";
        return view('auth.student.login');
    }
}
