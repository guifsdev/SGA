<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $guard = 'student';

    protected $fillable = ['nome', 'email', 'tel'];


    //student->certificates > [c1, c2, ...]
    public function certificates() {
    	return $this->hasMany('App\Certificate');
    }
    
}
