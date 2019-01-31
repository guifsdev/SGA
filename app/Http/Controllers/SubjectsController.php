<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;


class SubjectsController extends Controller
{
    //
    public function show(Request $request) {
	$subjects = Subject::where('period', $request->input('periodo'))->get();

	return response()->json($subjects);


	//return $disciplinas;
    
    }
}
