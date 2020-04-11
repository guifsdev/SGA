<?php

namespace App\Http\Controllers;

use App\Call;
use App\Lib\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServantCallsController extends Controller
{
	public function index(Settings $settings)
	{
		$calls = Call::with(['attachments', 'student'])->get();
		$statuses = $settings->get('calls')['statuses'];

		return response([
			'calls' => $calls, 
			'statuses' => $statuses], 200);
	}

	public function edit(Call $call, Request $request)
	{
		$status = $request->status;

		$call->resolved_at = $status == "Resolvido" ? Carbon::now()->toDateTimeString() : null;
		$call->status = $request->status;
		$call->result = $request->result;
		$result = $call->save();

		if($result) return response(['call' => $call, "message" => "Chamado resolvido com sucesso."], 200);
		else return response(['error' => 'Ocorreu um erro.'], 500);
	}


}
