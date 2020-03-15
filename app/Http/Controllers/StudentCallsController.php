<?php

namespace App\Http\Controllers;

use App\Lib\Settings;
use Illuminate\Http\Request;

class StudentCallsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:student');
	}

	public function create(Settings $settings)
	{
		$configs = $settings->get('calls');

		return response($configs, 200);
	}
}
