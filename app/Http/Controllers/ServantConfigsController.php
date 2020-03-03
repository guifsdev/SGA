<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServantConfigsController extends Controller
{
    public function index()
	{
		$adjustmentConfigs = config('settings.adjustment');
		return response(['adjustment' => $adjustmentConfigs], 200);
	}
	public function update(Request $request)
	{
		$configs = collect($request->configs);

		$reasons = $configs['reasons_to_deny'];
		if(strlen($reasons) && strrpos($reasons, ';')) {
			$reasons = collect(explode(';', $reasons))
				->map(function($item) { return trim($item);})
				->filter(function($item) {
					return ($item != "") && !preg_match("/^outro$/i", $item);})
				->push("Outro")
				->toArray();
		} else return response(['error' => 'Erro no delimitador da lista de razões'], 400);

		$date = $configs['date'];
		$time = $configs['time'];

		$date['open'] = "${date['open']} ${time['open']}";
		$date['close'] = "${date['close']} ${time['close']}";

		$configs->forget('time');

		$configs->put('date', $date)
			->put('reasons_to_deny', $reasons);

		//config(['settings.adjustment' => $configs]);
		//Config::set('settings.adjustment', $configs->toArray());
		//File::put(config_path() . '/settings.php', $configs->toArray());
		$file = require config_path('settings.php');
		$conf = new \Illuminate\Config\Repository($file);

		$value = \Illuminate\Support\Arr::get($conf, 'adjustment');


		return response(['adjustment' => config('settings.adjustment')], 200);
	}
}
