<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth_student');
    }


    public function index()
    {
    	return view('estudante.index');
    }
}
