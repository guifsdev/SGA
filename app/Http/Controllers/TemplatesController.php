<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

class TemplatesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	$templates = Template::getPaths();
    	return view('admin.eventos.templates.index', compact('templates'));

    }

    public function store(Request $request) 
    {
    	dd($request['file']);
    }
}
