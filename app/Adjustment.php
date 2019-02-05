<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\ConfigAdjustment;
use Carbon\Carbon;

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
		'autenticacao',
		'motivo_indeferido'
	];
	public static function defer(Request $request)
	{
		foreach ($request['id'] as $key => $id) {
			# code...
			Adjustment::where('id', $id)->
				update([
					'resultado' => 'Deferido',
					'motivo_indeferido' => ''
				]);

			//Enviar email
		}
		return response()->json(['success' => 'Dados atualizados com sucesso']);
	}

	public static function deny(Request $request) 
	{
		//dd($request);
		foreach ($request['id'] as $key => $id) {
			Adjustment::where('id', $id)
				->update([
					'resultado' => 'Indeferido',
					'motivo_indeferido' => $request['motivo-indeferir'] == 'outro' ? $request['motivo-descricao'] : $request['motivo-indeferir']
				]);

			//Enviar email
		}
		return response()->json(['success' => 'Dados atualizados com sucesso']);
	}

	public static function isOpen()
	{
		$datas = (new ConfigAdjustment())->dates();

		$abertura = new Carbon($datas['abertura']);
		$fechamento = new Carbon($datas['fechamento']);
		$now = Carbon::now();

		if(($now >= $abertura) && ($now <= $fechamento)) return true;
		else return false;
	}
}


