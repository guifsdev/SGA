<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
	protected $guarded = [];


    public function event() {
    	return $this->belongsTo('App\Event');
    }
    public function store($attributes) {
        $queryType;
        //existe um estudante que participou no evento.
        $certificate = Certificate::where([
            'student_id' => $attributes['student_id'],
            'event_id' => $attributes['event_id'],
        ]);

        if($certificate->count() > 0) {
            $queryType = 'update';
            $certificate->update(['template' => $attributes['template']]);
            $certificate = Certificate::where($attributes)->first();
        }
        else {
            $queryType = 'create';
            $certificate = Certificate::create($attributes);
        }

        if($certificate) {
            $studentData = array(
                'nome' => $certificate->student->nome,
                'cpf' => $certificate->student->cpf,
                'email' => $certificate->student->email,
                'matricula' => $certificate->student->matricula);
            return array('success' => true, 'student' => $studentData, 'queryType' => $queryType);
        }
        return array('success' => false);

    }
}
