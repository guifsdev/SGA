<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Settings;

class ServantConfigsController extends Controller
{
    public function index(Settings $settings)
	{
		return response($settings->all(), 200);
	}

	public function updateAdjustmentConfigs($configs, $settings)
	{
		$configs = $configs->except('context');

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

		$settings->put('adjustment', $configs);

		return $settings->get('adjustment');
	}
	public function updateCallsConfigs($configs, $settings)
	{
		$configs = $configs->except('context');
		$settings->put('calls', $configs);

		return $settings->get('calls');
	}


	public function update(Request $request, Settings $settings)
	{
		$configs = collect($request->configs);
		$context = ucfirst($configs['context']);

		$updateContext = "update${context}Configs";
		$updated = $this->$updateContext($configs, $settings);


		return response([strtolower($context) => $updated], 200);
	}
}
