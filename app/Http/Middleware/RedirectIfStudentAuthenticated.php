<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfStudentAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    //checks for guest student
    public function handle($request, Closure $next, $guard = 'student')
    {
        if(Auth::guard($guard)->check()) {
            return redirect('/estudante/');
        }
        return $next($request);
    }
}
