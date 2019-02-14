<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Division;

class Subject extends Model
{
    //Subject->divisions

    public function divisions()
    {	
    	//return "hey";
    	return $this->hasMany('App\Division', 'subject_id');
    }

    public function fromPeriod($period)
    {
    	$subjects = Subject::where('period', $period)->get();
    	
    	$offeredDivisions = [];

    	foreach ($subjects as $s => $subject) {
    		foreach ($subject->divisions as $d => $division) {
    			if($division->offered) {
    				/*array_push($offeredDivisions, 
    					[
    						'name' => $subject->name,
    						'division' => $division->name
    					]);*/
					array_push($offeredDivisions, $subject->name . ' ' . $division->name);
    			}
    		}
    	}
    	return $offeredDivisions;
    }


}
