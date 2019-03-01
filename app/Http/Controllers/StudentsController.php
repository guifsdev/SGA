<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Certificate;
use App\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CertificatesController;

class StudentsController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth_student');
    }


    public function index()
    {
    	return view('estudante.index');
    }
    public function update() 
    {
        $attributes = request()
            ->validate([
                'nome' => ['required', 'min:3'],
                'email' => 'required',
                'tel' => 'required',
            ]);

        $id = Auth::guard('student')->user()->id;

        Student::where('id', $id)->update($attributes);

        //$html = view('estudante.home')->render();
        return array('success' => true);

    }
}
