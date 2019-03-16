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


    public function index()
    {

        $count = Adjustment::all()->count();
        $status = Adjustment::isOpen();

        $pendentes = Adjustment::where('resultado', 'Pendente')->count();
        $deferidos = Adjustment::where('resultado', 'Deferido')->count();
        $indeferidos = Adjustment::where('resultado', 'Indeferido')->count();
        $novos = Adjustment::recent()->count();
        $settings = Setting::fromAdjustment();
    	return view('admin.panel', compact('count', 'status', 'settings', 'pendentes', 'deferidos', 'indeferidos', 'novos'));
    }
    
}
