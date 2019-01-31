<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCertificatesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function show()
    {
    	return "AdminCertificatesController@show";
    }

    public function configure()
    {
    	return 'AdminCertificatesController@configure';
    }
}
