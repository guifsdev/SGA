<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
	public function __construct()
	{
		//$this->middleware('student');
	}


	public function dashboard()
	{
		return view('estudante.index');
	}


}
