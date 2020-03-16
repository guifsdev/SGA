<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;
use App\ConfigAdjustment;
use App\Setting;
use Carbon\Carbon;
use App\Student;
use App\Subject;
use App\Certificate;
use App\Event;
use App\Template;


class AdminController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


    public function index() {
        $adjustment = Adjustment::info();
        $students = [
        	'count' => count(Student::all()),
        	'last_merge' => Setting::where('nome', 'data_merged')->first()['valor'],
        ];
        $subjects = [
        	'count' => count(Subject::all()),
        	'offered' => count(Subject::where('offered', true)->get()),
    	];
    	$certificates = [
    		'count' => count(Certificate::all()),
    	];
    	$events = [
    		'count' => count(Event::all()),
    	];
    	$templates = [
    		'count' => count(Template::listNames()),
		];


    	return view('admin.panel', compact('adjustment', 'students', 'subjects', 'certificates', 'events', 'templates'));
    }
    
}
