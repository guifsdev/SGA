<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    protected $fillable = [
    	'nome',
		'cpf',
		'matricula',
		'email',
		'tel',
		'disciplina',
		'periodo',
		'requerimento',
		'resultado',
		'autenticacao'
	];
}


