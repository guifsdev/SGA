<?php

namespace App\Http\Controllers;

use App\Adjustment;
use Illuminate\Http\Request;

class ServantAdjustmentController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth:servant');
    }

    public function index() {
		$adjustments = Adjustment::with(['student', 'subject'])
			->get()
			->map(function($adjustment) {
				$adjustment['student_name'] = $adjustment->student->full_name;
				$adjustment['cpf'] = $adjustment->student->cpf;
				$adjustment['enrolment_number'] = $adjustment->student->enrolment_number;
				$adjustment['subject_name'] = $adjustment->subject->full_name;
				$adjustment = collect($adjustment)
					->forget(['student', 'subject'])
					->toArray();
				return $adjustment;
			});
		return response($adjustments, 200);
    }
}
