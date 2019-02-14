<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\Division;


class SubjectsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
    	$subjects = Subject::all();

    	/*foreach ($subjects as $key => $subject) {
    		if ($key == 7) {
    			foreach ($subject->divisions as $key => $division) {
    				dd($division);
				}
    		}
    	}*/
    	return view('admin.disciplinas.index', compact('subjects'));
    }

    public function show(Subject $subject, Division $division)
    {
    	//dd($subject, $division);
    	return view('admin.disciplinas.show', compact('subject', 'division'));
    }

    public function edit(Subject $subject, Division $division)
    {
    	//dd($subject, $division);
    	return view('admin.disciplinas.edit', compact('subject', 'division'));
    }


    //public function update
}
