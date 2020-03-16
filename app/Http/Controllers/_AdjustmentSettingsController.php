<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class AdjustmentSettingsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }
    public function show()
    {
    	$settings = Setting::fromAdjustment();
        return view('admin.ajuste.configure.show', compact('settings'));
    }

    public function edit()
    {
    	$settings = Setting::fromAdjustment();
    	return view('admin.ajuste.configure.edit', compact('settings'));
    }

    public function save(Request $request)
    {
    	Setting::store($request);
    	return redirect('/admin/ajuste/config');
    }
    
}
