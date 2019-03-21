<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Event extends Model
{
    protected $fillable = [
    	'nome', 
        'descricao',
    	'local', 
    	'data', 
    	'tipo', 
    	'duracao', 
    	'carga_horaria',
    	'organizador',
	];

    //event->certificates > []
    public function certificates() {
        return $this->hasMany('App\Certificate');
    }


    public static function findEvents($matricula)
    {
        $events = Event::whereRaw('JSON_CONTAINS(`participantes`, \' {"matricula":"'. $matricula .'"} \')')->get();

        if(count($events) == 0) return false;

        return $events;
    }
}
