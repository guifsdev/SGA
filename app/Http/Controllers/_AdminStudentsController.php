<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\ActiveStudents;
use App\Setting;

class AdminStudentsController extends Controller
{
    public function index() {
        $students = Student::orderBy('nome', 'ASC')->paginate(20);
    	return view('admin.estudantes.index', compact('students'));
    }

    public function merge(Request $request) {
        $request = $request->all();
        $tmp = array_values($request);
        $activeStudents = array_shift($tmp);

        $result = Student::merge($activeStudents);
        return response($result, $result['code']);
    }

    public function update(Student $student, $email) {
    	$student->email = $email;
    	$student->save();
    }

}
