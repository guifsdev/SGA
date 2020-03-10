<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

			return '/login';
			//if(preg_match('/estudante/', $request->path())) {
				//return 'estudante/login';
			//}
			//if(preg_match('/servidor/', $request->path())) {
				//return 'servidor/login';
			//}
            //return route('login');
        }
    }
}
