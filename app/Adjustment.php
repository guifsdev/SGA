<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\ConfigAdjustment;
use Carbon\Carbon;
use App\Setting;

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



	public static function store(Request $request)
	{
        $autenticacao = md5(uniqid(rand(), true));
        $dataHora = Carbon::now();

        for($i = 1; $i <= count(request('periodo-ajuste')); ++$i)
        {
            Adjustment::create([
                'nome' => $request['nome'],
                'cpf' => $request['cpf'],
                'matricula' => $request['matricula'],
                'email' => $request['email'],
                'tel' => $request['tel'],
                'disciplina' => $request['disciplina-ajuste'][$i],
                'periodo' => $request['periodo-ajuste'][$i],
                'requerimento' => $request['acao-ajuste'][$i],
                'resultado' => 'Pendente',
                'autenticacao' => $autenticacao
            ]);
        }

        $result = ['autenticacao' => $autenticacao, 'dataHora' => $dataHora];
        return $result;
	}

	public static function isOpen()
	{
		$settings = Setting::fromAdjustment();
		$now = Carbon::now()->format('Y-m-d\TH:i:s');
		//dd($settings, $now);

		if(($now >= $settings['data_abertura']) && ($now <= $settings['data_fechamento'])) return true;
		else return false;
	}

	public static function recent()
	{
		$today = Carbon::today();
		return Adjustment::where('created_at', '>', $today);
	}

}


