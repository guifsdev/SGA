<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;


class Consulta extends Model
{
	protected $fillable = ['matricula', 'token_consulta', 'data_consulta'];

	public function add($matricula, $token) {
		$this->create([
			'matricula' => $matricula,
			'token_consulta' => $token,
			'data_consulta' => Carbon::now()->toDateTimeString()
		]);
	}
}
