<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    protected $fillable = ['name', 'period', 'code', 'offered'];
	protected $appends = ['code_name', 'name_class', 'offered_text'];
	public $timestamps = true;

	public function getOfferedTextAttribute()
	{
		return $this->offered ? 'Sim' : 'Não';
	}
	public function getCodeNameAttribute()
	{
		return "{$this->code} {$this->name}";
	}
	public function getNameClassAttribute()
	{
		return "{$this->name} {$this->class_name}";
	}

	public function store($file)
	{
        $acceptedHeader = ["code","name","period","class_name","offered"];

        $reader = Reader::createFromString($file);

        $reader->setHeaderOffset(0);
        $header = $reader->getHeader();
		
        //headers differ
        if(count(array_diff($header, $acceptedHeader)) > 0) {
            //dd(count(array_diff($header, $acceptedHeader)));
			return ['message' => __('subjects.update.error'),
				'status' => 422];
        }

		$records = $reader->getRecords();
		$subjects = [];

		foreach($records as $offset => $record) {
			array_push($subjects, $record);
		}
		$result = [
			'message' => null,
			'status' => null,
		];
		try {
			DB::transaction(function() use ($subjects, &$result) {
				Subject::query()->delete();
				$insert = Subject::insert($subjects);
				if($insert) {
					$result['message'] = __('subjects.update.success');
					$result['status'] = 200;
				} else {
					throw new Exception('Insertion failure.');
				}
			});

		} catch(QueryException $e) {
				$result['message'] = __('subjects.update.error');
				$result['status'] = 422;
		} catch (\Exception $e) {
			$result['message'] = __('subjects.update.error');
			$result['status'] = 422;
		} finally {
			return $result;
		}
	}
}
