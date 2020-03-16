<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;

class ServantSubjectsController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth:servant');
    }
	public function index(Request $request)
	{
		
		if($request->has('csv')) {
			return (new Subject())->allAsCsv();
		}
		$subjects = Subject::all();
		return response(['subjects' =>  $subjects ], 200);
	}

	public function store(Request $request)
	{
		$file = $request->csv;
		$response = (new Subject())->store($file);
		return response($response['message'], $response['status']);
	}
}
