<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Servant extends Authenticatable
{
    use Notifiable;
	//
	
	public $timestamps = true;
	
	public function getNameAttribute()
	{
		return ucfirst(strtolower($this->first_name));
	}
}
