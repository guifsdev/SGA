<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\ConfigAdjustment;
use Carbon\Carbon;
use App\Setting;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Adjustment extends Model
{
	protected $guarded = [];
	public $timestamps = true;

	const filter_columns = ['adjustments.id', 
							'student_id', 
							'students.nome as student_name', 
							'cpf as student_cpf', 
							'matricula as student_matricula', 
							'subjects.code as subject_code', 
							'subjects.name as subject_name', 
							'subjects.class_name as subject_class_name',
							'subject_id', 
							'subjects.period as subject_period',
							'reason_denied', 
							'action', 
							'adjustments.created_at', 
							'result'];

	//adjustment->subject->code
	public function subject() {
		return $this->belongsTo('App\Subject');
	}
	//adjustment->student
	public function student() {
		return $this->belongsTo('App\Student');
	}

	public static function store($student, $adjustments) {
		$signature = md5(uniqid(rand(), true));
        foreach($adjustments as $adjustment) {
        	Adjustment::create([
        		'student_id' => $student['id'],
                'email' => $student['email'],
            	'subject_id' => $adjustment['subject_id'],
                'action' => $adjustment['action'] == '1' ? 'incluir' : 'excluir',
                'result' => 'Pendente',
                'validation_string' => $signature,
        	])->save();
        }
    	$now = Carbon::now()->toDateTimeString();
    	return [
    		'success' => true, 
    		'adjustments' => $adjustments,
    		'stamp' => [
    			'date' => $now, 
    			'signature' => $signature
    			]
    		];
    		
	}
	public static function info() {
		return array(
			'is_open' => self::isOpen(),
			'status' => self::isOpen() ? 'Aberto' : 'Fechado',
			'count' => Adjustment::all()->count(),
			'pending' => Adjustment::where('result', 'Pendente')->count(),
			'deferred' => Adjustment::where('result', 'Deferido')->count(),
			'denied' => Adjustment::where('result', 'Indeferido')->count(),
			'new' => self::recent()->count(),
			'settings' => Setting::fromAdjustment(),
		);
	}
	public static function isOpen()	{
		$settings = Setting::fromAdjustment();
		$now = Carbon::now()->format('Y-m-d\TH:i:s');

		if(($now >= $settings['data_abertura']) && ($now <= $settings['data_fechamento'])) return true;
		else return false;
	}
	public static function recent()	{
		$today = Carbon::today();
		return Adjustment::where('created_at', '>', $today);
	}
	public function filter_get_interval($filter) {
		//not to repeat every time
		$result = null;
		$interval = [
			'from' => array_key_exists('created_at_start', $filter) ? 
				Carbon::createFromFormat('Y-m-d', $filter['created_at_start'])->startOfDay() : 
				null,
			'to' => array_key_exists('created_at_end', $filter) ? 
				Carbon::createFromFormat('Y-m-d', $filter['created_at_end'])->endOfDay() : 
				null,
		];
		//both values are set

		$adjustments = DB::table('adjustments')
						->select(self::filter_columns)
						->join('students', 'adjustments.student_id', '=', 'students.id')
						->join('subjects', 'adjustments.subject_id', '=', 'subjects.id');


		if($interval['from'] && $interval['to']) {
			$result = $adjustments
						->whereBetween('adjustments.created_at', [$interval['from'], $interval['to']])
						->get();
		}
		//from is set
		else if($interval['from'] && !$interval['to']) {
			$result = $adjustments
						->where('adjustments.created_at', '>=', $interval['from'])
						->get();
		}
		//to is set
		else if($interval['to'] && !$interval['from']) {
			$result = $adjustments
						->where('adjustments.created_at', '<=', $interval['to'])
						->get();
		}
		return $result;
	}
	public function array_match($dest, $match) {
		$matches = array();
		foreach($match as $i => $k) {
			foreach ($dest as $j => $l) {
				$intersection = array_intersect_assoc($k, $l);
				if(count($intersection) == count($k)) array_push($matches, $intersection);
			}
		}
		return $matches;
	}
	public function filter($filter) {
		if(!$filter) {
			return DB::table('adjustments')
						->select(self::filter_columns)
						->join('students', 'adjustments.student_id', '=', 'students.id')
						->join('subjects', 'adjustments.subject_id', '=', 'subjects.id')
						->where('result', 'Pendente')
						->get();	
		}

		$type = $filter['filter_type'];
		$student_attributes = ['student_name', 'student_cpf', 'student_matricula'];
		$adjustment_attributes = ['subject_period', 'subject_id', 'action', 'result'];
		$skip = ['filter_type', 'created_at_start', 'created_at_end'];

		$result = null;
		$result = $this->filter_get_interval($filter);

		foreach ($filter as $key => $value) {
			if(in_array($key, $skip)) continue;

			$adjustments = DB::table('adjustments')
								->select(self::filter_columns)
								->join('students', 'adjustments.student_id', '=', 'students.id')
								->join('subjects', 'adjustments.subject_id', '=', 'subjects.id');	
			$found = null;

			$column = $key;
			switch ($key) {
				case 'student_name': $column = 'students.nome'; break;
				case 'student_cpf': $column = 'students.cpf'; break;
				case 'student_matricula': $column = 'students.matricula'; break;
				case 'subject_period': $column = 'subjects.period'; break;
				case 'subject_id': $column = 'subjects.id'; break;
			}

			if($column == 'students.nome') {
				$found = $adjustments->whereRaw('replace('.$column.', "  ", " ") like "%' . $value . '%"')->get();				
			}

			else {
				if($value == 'all') $found = $adjustments->get();
				else $found = $adjustments->where($column, $value)->get();
			} 

			if($found)  {
				if($found->count() && $type == 'and') {
					$found = json_decode(json_encode($found), true);
					
					if(gettype($result) == 'object') {
						$result = json_decode(json_encode($result), true);
						//$intersection = $this->intersect_arrays($found, $result);
						$intersection = $this->array_match($result, $found);
									//if($key == 'action') dd('result:', $result, 'found:', $found);
						$result = collect($intersection);

					}
					else $result = collect($found);
					$found = collect($found);
				}
				if($found->count() && $type == 'or') {
					$result = gettype($result) == 'object' ? $result->merge($found) : $result = $found;

				}
				
				if($found->count() == 0 && $type == 'and') {
					$result = null;
					break;
				}
			}
		}//end foreach
		//dd($result);
		return $result;
	}
	public static function defer($adjustBag) {
		foreach ($adjustBag['ids'] as $id) {
			$adjustment = Adjustment::where('id', $id)
							->update([
								'result' => 'Deferido',
								'reason_denied' => null,
							]);
			if(!$adjustment) return false;
		}
		$adjustBag['succes'] = true;
		$adjustBag['result'] = 'Deferido';
		return $adjustBag;
	}
	public static function deny($adjustBag) {
		foreach ($adjustBag['ids'] as $id) {
			$adjustment = Adjustment::where('id', $id)
							->update([
								'result' => 'Indeferido',
								'reason_denied' => $adjustBag['reason'],
							]);
			if(!$adjustment) return false;
		}
		$adjustBag['succes'] = true;
		$adjustBag['result'] = 'Indeferido';
		return $adjustBag;
	}	
}


