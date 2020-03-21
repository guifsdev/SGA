<?php

namespace App\Http\Controllers;

use App\Call;
use App\Lib\Settings;

class ServantCallsController extends Controller
{
	public function index(Settings $settings)
	{
		$calls = Call::with(['attachment', 'student'])->get();
		$statuses = $settings->get('calls')['statuses'];

		return response([
			'calls' => $calls, 
			'statuses' => $statuses], 200);
	}
}
