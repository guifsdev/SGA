<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public $guard;
  public function __construct()
  {

    $this->middleware(function ($request, $next) {
      $this->guard = $this->getGuard();
      if(!$this->guard) return redirect('/login');
      else return $next($request);
    });

  }
  public function index()
  {
    return view('home', 
      [ 'data' => Auth::guard($this->guard)->user(),
        'guard' => $this->guard
      ]
    );

  }
  public function getGuard()
  {
    if(Auth::guard('student')->check()) { return 'student'; }
    elseif(Auth::guard('servant')->check()) { return 'servant'; }
    else return null;
  }

}
