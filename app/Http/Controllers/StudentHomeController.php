<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class StudentHomeController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:student');
	}

	public function home()
	{
		$student = Auth::guard('student')->user();
    	return view('student.home', ['student' => $student]);
	}
}
