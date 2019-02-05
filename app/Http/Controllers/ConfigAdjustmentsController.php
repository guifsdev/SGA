<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigAdjustment;

class ConfigAdjustmentsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }
    public function show()
    {
    	$datas = (new ConfigAdjustment)->dates();

        return view('admin.ajuste.configure.show', compact('datas'));
    }

    public function edit()
    {

    	$datas = (new ConfigAdjustment())->dates();

    	return view('admin.ajuste.configure.edit', compact('datas'));
    }

    public function save(Request $request)
    {
    	ConfigAdjustment::store($request);
    	return redirect('/admin/ajuste/config');
    }
	
}
