<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimento extends Model
{
    
    protected $fillable = [
        'nome', 'email', 'matricula', 'disciplina', 'periodo', 'acao', 'status'
    ];

    public static function mostrarPendentes() {
    	return static::all();
    }
}
