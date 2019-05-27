<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\Division;


class SubjectsController extends Controller
{

	public function __construct()
	{
		//$this->middleware('admin')->except('subjects');
	}

    public function index()
    {
    	$subjects = Subject::all();
    	return view('admin.disciplinas.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
    	return view('admin.disciplinas.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
    	return view('admin.disciplinas.edit', compact('subject'));
    }

    public function subjects(Request $request) 
    {
        $subjects = Subject::fromPeriod($request->period);
        return response()->json($subjects);
    }

    public function update(Subject $subject)
    {
        $attributes = request()->validate([
            'code' => 'required',
            'name' => 'required',
            'period' => 'required',
            'class-name' => 'required',
            'offered' => 'required|boolean',
        ]);
        $attributes['offered'] = (bool) $attributes['offered'];

        $subject = Subject::find($subject->id);
        $subject->update($attributes);

        return redirect('/admin/disciplinas')->with('success','Disciplina/Turma alterada com sucesso.');
    }
}
