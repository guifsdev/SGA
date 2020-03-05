<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Certificate

class StudentCertificatesController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('auth:student');
	}

	public function index()
	{
		$cpf = Auth::guard('student')->user()->cpf;
		$certificates = Certificate::with('event')
			->where('cpf', $cpf)
			->get();
		return response(['certificates' => $certificates], 200);
	}
}
