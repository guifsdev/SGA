<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //certificate->students > [student1, student2, ...]
    public function student() {
    	return $this->belongsTo('App\Student');
    }

    //certificate->event > event
    public function event() {
    	return $this->belognsTo('App\Event');
    }
}
