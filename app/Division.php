<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

	protected $fillable = ['division_name', 'offered'];
	//Division->subject
	//ADM... P1
	//ADM... P2


    public function subjects()
    {
    	return $this->hasMany('App\Subject');
    }
}
