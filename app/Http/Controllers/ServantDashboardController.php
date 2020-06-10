<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ServantDashboardController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth:servant');
	}
	public function index()
	{
		$servant = Auth::guard('servant')->user();
        //return view('servant.home', ['servant' => $servant]);
		return view('servant.dashboard', ['servant' => $servant]);
	}
}
