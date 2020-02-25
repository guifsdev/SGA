<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'period', 'code', 'offered'];

	public function getFullNameAttribute()
	{
		return "{$this->code} {$this->name}";
	}

    public static function addNames($adjustments) {
        $out = array();
        foreach ($adjustments as $adjustment) {
            $subject = Subject::find($adjustment['subjectId']);
            $adjustment['subject'] = $subject;
            $adjustment['subject_name'] = $subject->name;
            $adjustment['class_name'] = $subject->class_name;
            $adjustment['period'] = $subject->period;
            array_push($out, $adjustment);
        }
        return $out;
    }
    public static function fromPeriod($period) {
        $subjects = Subject::where('period', $period)
            ->where('offered', true)
            ->get();

        return $subjects;
    }
}
