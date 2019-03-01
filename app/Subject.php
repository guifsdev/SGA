<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Division;

class Subject extends Model
{
    //Subject->divisions
    protected $fillable = ['name', 'period', 'code', 'offered'];

    public function divisions()
    {	
    }

    public function fromPeriod($period)
    {
        $subjects = Subject::where('period', $period)
            ->where('offered', true)
            ->get();

        return $subjects;
    }
}
