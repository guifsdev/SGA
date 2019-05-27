<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'student')
    {   
        $check = Auth::guard($guard)->check();
        if(!$check) {
            return response(['success' => false, 
                'reason' => 'Student not authenticated'], 403);
        }
        return $next($request);
    }
}
