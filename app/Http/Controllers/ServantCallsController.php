<?php

namespace App\Http\Controllers;

use App\Call;
use App\Lib\Settings;
use Illuminate\Http\Request;

class ServantCallsController extends Controller
{
	public function index(Settings $settings)
	{
		$calls = Call::with(['attachment', 'student'])->get();
		$statusList = $settings->get('calls')['status_list'];

		return response([
			'calls' => $calls, 
			'status_list' => $statusList], 200);
	}
}
