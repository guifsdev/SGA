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
    	$config = (new ConfigAdjustment)->getConfig();
        return view('admin.ajuste.configure.show', compact('config'));
    }

    public function edit()
    {

    	$config = (new ConfigAdjustment())->getConfig();

    	return view('admin.ajuste.configure.edit', compact('config'));
    }

    public function save(Request $request)
    {
    	ConfigAdjustment::store($request);
    	return redirect('/admin/ajuste/config');
    }
	
}
