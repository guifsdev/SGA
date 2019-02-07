<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;
use App\ConfigAdjustment;


class AdminController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


    public function index()
    {
        $count = Adjustment::all()->count();
        $status = Adjustment::isOpen() ? 'Aberto' : 'Fechado';
        $datas = (new ConfigAdjustment)->dates();
        $pendentes = Adjustment::where('resultado', 'Pendente')->count();
        $deferidos = Adjustment::where('resultado', 'Deferido')->count();
        $indeferidos = Adjustment::where('resultado', 'Indeferido')->count();
        $novos = Adjustment::recent()->count();

    	return view('admin.panel', compact('count', 'status', 'datas', 'pendentes', 'deferidos', 'indeferidos', 'novos'));
    }
    
}
