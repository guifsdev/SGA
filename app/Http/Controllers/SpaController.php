<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;

class SpaController extends Controller
{
	public function __construct() {
		$this->middleware('auth_student');
	}
    public function index() {
    	$status = Adjustment::isOpen();
    	return view('estudante.dashboard');
    }
}
