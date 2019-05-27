<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;
use App\ConfigAdjustment;
use App\Setting;
use Carbon\Carbon;


class AdminController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


    public function index() {
        $adjustment = Adjustment::info();

    	return view('admin.panel', compact('adjustment'));
    }
    
}
