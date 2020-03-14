<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;
use App\Lib\Settings;
use App\Subject;
use Carbon\Carbon;
use Validator;
use App\Mail\AdjustmentSent;


class StudentAdjustmentController extends Controller
{

	public function __construct()
	{
        $this->middleware('auth:student');
    }

	public function index(Request $request, Settings $settings)
	{
		$configs = collect($settings->get('adjustment'));
		$closedTemporarily = $configs['closed_temporarily'];
		$date = $configs->get('date');

		$now = Carbon::now();
		$open = (( $date['open'] <= $now ) && ( $date['close'] >= $now ) ) ? true : false;
		//$status = $closedTemporarily ? 'closed_temporarily' : 'open';
		$status = '';
		if($closedTemporarily)  $status = 'closed_temporarily';
		else $status = $open ? 'open' : 'closed';

		if($open) {
			$data = [];
			//Check if student already has adjustments
			$pendingAdjustments = Adjustment::where('student_id', $request->student_id)
				->where('created_at', '>=', $date['open'])
				->with('subject')
				->get();
			$data = [
				'status' => $status,
				'open' => $open,
				'periods' => Subject::all()->max('period'),
				'max_adjustments' => intval($configs->get('max_adjustments')),
				'subjects' => Subject::all(),
				'pending_adjustments' => $pendingAdjustments,
			];
			return response($data, 200);
		}
		return response([ 'status' => $status, 'open' => $open, 200]);
	}
    
    public function store(Request $request) {

        $student = $request->student;
        $adjustments = $request->adjustments;
		$signature = md5(uniqid(rand(), true));

		$values = collect($adjustments)
			->map(function($adjustment) use ($student, $signature) {
				$adjustment = collect($adjustment);
				return collect([
					"subject_id" => $adjustment['subject']['id'],
					"action" => $adjustment['action'],
					"student_id" => $student['id'],
					"signature" => $signature,
					"result" => "Pendente",
					"created_at" => Carbon::now(),
					"updated_at" => Carbon::now(),
				])->toArray();
			})->toArray();

		$result = Adjustment::insert($values);
	
		$email = $student['email_primary'] ? $student['email_primary'] : $student['email_secondary'];
        if($result) {
            $mail = \Mail::to($email)->send(new AdjustmentSent($student['first_name'], $adjustments, $signature));
            return response([
                    'success' => true,
                    'message' => __('adjustment.success'),
                    'signature' => $signature], 200);
        }
		else return response([
				'success' => false,
				'message' => __("adjustment.failed")], 503);
    }






}
