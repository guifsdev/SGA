<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificate;
use App\Event;
use App\Template;

class AdminCertificatesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index() {
        $certificates = Certificate::all();
        return view('admin.certificados.index', compact('certificates'));
    }

    public function create() {
        $events = Event::all();
        $templates = Template::listNames();
        return view('admin.certificados.create', compact('events', 'templates'));
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
