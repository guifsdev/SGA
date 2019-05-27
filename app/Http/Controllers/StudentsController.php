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
    public function __construct()
    {
    	$this->middleware('auth_student')->except('find');
    }

    public function home() {
        return view('estudante.home');
    }

    public function update(Request $request) 
    {
        $attributes = $request
            ->validate([
                'email' => 'required',
                'tel' => 'required',
            ]);

        $id = Auth::guard('student')->user()->id;

        Student::where('id', $id)->update($attributes);
        return ['success' => true, 'message' => 'Dados atualizados com sucesso!'];


    }
    public function find($input) {
        $studentData = Student::findStudent($input);
        return array('success' => true, 'student' => $studentData);
    }

    public function certificates(Request $request) {
        $cpf = $request->validate(['cpf' => 'required']);
        $certificates = Certificate::with('event')->where('cpf', $cpf)->get();
        if($certificates) {
            return response(['succes' => true, 'certificates' => $certificates], 200);
        }

    }
}
