<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Setting extends Model
{
    //
    public static function fromAdjustment() {
    	$settings = Setting::where('grupo', 'ajuste')
    		->get(['nome', 'valor'])
    		->map(function($s) { return [$s['nome'] => $s['valor']];})
    		->toArray();

    	$arr = array();
    	foreach($settings as $s) { 
    	  $arr[key($s)] = $s[key($s)];

    	}
    	$arr['data_abertura'] = (new Carbon($arr['data_abertura']))->format('Y-m-d\TH:i:s');
    	$arr['data_fechamento'] = (new Carbon($arr['data_fechamento']))->format('Y-m-d\TH:i:s');

		return $arr;
    }
    public static function store(Request $request)
    {
        $settings = [
            'data_abertura' => (new Carbon($request->abertura))->format('Y-m-d\TH:i:s'),
            'data_fechamento' => (new Carbon($request->fechamento))->format('Y-m-d\TH:i:s'),
            'max_ajustes' => $request->max_ajustes,
        ];

    	foreach ($settings as $key => $value) {
    		Setting::where('nome', $key)->update(['valor' => $value]);
    	}
    }
}
