<?php

namespace App\Http\Controllers;

use App\Lib\Settings;
use Illuminate\Http\Request;
use App\Call;
use App\Student;

class StudentCallsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:student');
	}

	public function create(Request $request, Settings $settings)
	{
		$configs = $settings->get('calls');
		$pending = Call::where('student_id', $request->student_id)
			->get();

		return response([
			'configs' => $configs,
			'pending' => $pending,
		], 200);
	}

	public function store(Request $request)
	{
		$data = json_decode($request->data, true);
		$attachments = null;
		if($request->has('files')) {
			$attachments = $request->instance()->files->all();
			$attachments = $attachments['files'];
		}
		return (new Call())->store($data, $attachments);

	}
}
