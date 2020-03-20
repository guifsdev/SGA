<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mail\AdjustmentResolved;
use Carbon\Carbon;
use App\Setting;
use Illuminate\Database\Eloquent\Builder;

class Adjustment extends Model
{
	protected $guarded = [];
	public $timestamps = true;

	public function subject() 
	{
		return $this->hasOne('App\Subject', 'code', 'subject_code');
	}

	public function student() 
	{
		return $this->belongsTo('App\Student');
	}

	public function index($filters, $settings) 
	{
		$query = Adjustment::query()->with(['student', 'subject']);


		if($filters) {
			$params = collect(explode('&', $filters));
			$filterType = explode('=', $params[0])[1] == 'and' ? 'where' : 'orWhere';

			$params->forget(0);

			$params->map(function($param) use ($query, $filterType) {

				$scope = $filterType;

				preg_match('/\[(\w+)\]/', $param, $match);
				$operator = count($match) == 2 ? $match[1] : '=';
				$operator = $operator == 'contains' ? 'like' : $operator;

				$pair = ($operator == '=') ? explode('=', $param) :
					explode('=', preg_replace("/".preg_quote($match[0])."/", '', $param));

				$value = urldecode($pair[1]);
				$columnName = $pair[0];

				if(in_array($columnName, ['student_name', 'cpf', 'enrolment_number', 'subject_name']))
					$scope = "${filterType}Has";

				if($columnName == 'student_name') {
					
					$query->$scope('student', function(Builder $q) use ($value, $operator) {
						if($operator == 'like') 
							$q ->where('first_name', $operator, "%${value}%")
								->orWhere('last_name', $operator, "%${value}%");
						else $q->where('first_name', $operator, $value)
								->orWhere('last_name', $operator, $value);
					}); 
				}
				elseif(in_array($columnName, ['cpf', 'enrolment_number'])) {
					$query->$scope('student', function(Builder $q) use ($value, $columnName, $operator) {
						if($operator == 'like') $q->where($columnName, $operator, "%${value}%");
						else $q->where($columnName, $operator, $value);
					});
				} 
				elseif($columnName == 'subject_name') {
					$columnName = 'code';
					//Get subject code...
					$value = preg_match('/\w{3}\d{5}/', $value, $matches);
					$value = $matches[0];

					$query->$scope('subject', function(Builder $q) use ($value, $columnName, $operator) {
						$q->where($columnName, $operator, $value);
					});
				}
				elseif($columnName == 'created_at') {
					switch($operator) {
					case "before" : $query->whereDate($columnName, '<=',$value); break;
					case "after" : $query->whereDate($columnName, '>=',$value); break;
					default: $query->whereDate($columnName, $value); 
					}
				} 
				else $query->$scope($columnName, $value);
			});
		}

		$adjustments = $query->get();

		$reasonsDenied = $this->getReasonsDenied($adjustments);


		$results = $adjustments->map(function($item) {
			return $item['result'];
		})->unique()->sort()->toArray();

		$adjustments->map(function($adjustment) {
			$student = $adjustment['student'];
			$studentFullName = $student['first_name'].' '.$student['last_name'];

			$subject = $adjustment['subject'];
			$subjectFullName = "${subject['code']} ${subject['name']} ${subject['class_name']}";
			//
			$adjustment['student_name'] = $studentFullName;
			$adjustment['cpf'] = $student['cpf'];
			$adjustment['enrolment_number'] = $student['enrolment_number'];
			$adjustment['subject_name'] = $subjectFullName;
			$adjustment = collect($adjustment)
				->forget(['student', 'subject'])
				->toArray();
			
			return $adjustment;
		});

		//dd($adjustments);
		$subjects = $adjustments->map(function($adjustment) {
				return $adjustment['subject_name'];
			})
			->unique()->sort()->toArray();
		$reasonsToDeny = $settings->get("adjustment")['reasons_to_deny'];

		return response([
			'adjustments' => $adjustments, 
			'subjects' => array_values($subjects),
			'reasons_denied' => array_values($reasonsDenied),
			'results' => array_values($results),
			'reasons_to_deny' => $reasonsToDeny,
		], 200);
	}

	public function resolve($adjustments, $decision, $reason, $configs)
	{
		$result = $decision == 'deny' ? 'Indeferido' : 'Deferido';
		$studentAdjustments = collect([]);
		$adjustmentIds = [];

		foreach($adjustments as $adjustment) {
			$studentId = $adjustment['student_id'];
			$adjustmentId = $adjustment['id'];
			$action = $adjustment['action'];

			$subject = $adjustment['subject'];
			$subjectAction = collect($adjustment['subject'])
				->put('action', $action)
				->put('subject_name', "${subject['code']} ${subject['name']} ${subject['class_name']}");

			if($studentAdjustments->has($studentId)) {
				$studentAdjustments[$studentId]['adjustments']->push($subjectAction);
			} else {
				$student = collect($adjustment['student'])
					->only(['id', 'first_name', 'last_name', 
					'email_primary', 'email_secondary'])
					->toArray();

				$studentAdjustments->put($studentId, [
					'student' => $student, 
					'adjustments' => collect([$subjectAction])]);
			}
			array_push($adjustmentIds, $adjustmentId);
		}
		//Update records.
		$updated = Adjustment::whereIn('id', $adjustmentIds)
			->update(['result' => $result, 'reason_denied' => $reason]);

		if(!$updated) {
			return response(['error' => 'Falha na atualização dos registros. (500)'], 500);
		}
		$notify = $configs['notify_result'];

		//Send out emails
		if($updated && $notify) {
			$studentAdjustments->each(function($studentAdjustment) use ($reason, $result) {
				$student = $studentAdjustment['student'];
				$adjustments = $studentAdjustment['adjustments'];
				$email = $student['email_primary'] ? $student['email_primary'] : $student['email_secondary'];

				\Mail::to($email)->send(new AdjustmentResolved($student['first_name'], $adjustments, $result, $reason));
				sleep(2);
			});
		}
		$reasonsDenied = $this->getReasonsDenied();

		return response(
			[
				'updated' => $updated, 
				'id' => $adjustmentIds, 
				'result' => $result, 
				'reasons_denied' => array_values($reasonsDenied),
				'reason' => $reason], 200);
	}

	public function getReasonsDenied($adjustments = null)
	{
		if(!$adjustments) $adjustments = Adjustment::all();

		return $adjustments->map(function($item) {
			return $item['reason_denied'] ?: 'Vazio';
		})->unique()->sort()->toArray();
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


