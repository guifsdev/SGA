<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ServantHomeController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth:servant');
	}
	public function home()
	{
		$servant = Auth::guard('servant')->user();
    	return view('servant.home', ['servant' => $servant]);
	}
}
