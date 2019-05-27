<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CertificatesController extends Controller
{
	public function __construct() {
		$this->middleware('auth_student')->except('validate');
	}
	public function print(Certificate $certificate) {
	    $student = Auth::guard('student')->user();

	    abort_unless(($certificate->cpf == $student->cpf), 403);

	    $hash = substr(md5(uniqid(rand(), true)), 16, 16);

	    $url = Storage::url('certificados/templates/' . $certificate->template . '.png');

	    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		$today = strftime('%d de %B de %Y', strtotime('today'));
		$eventDay = strftime('%d de %B de %Y', strtotime($certificate->event->data));
		$now = date('H:i:s');

	    $exists = Storage::disk('certificados')->exists('/templates/' . $certificate->template . '.png');
	    $file = $certificate->template . '.png';
	    if($exists) {
	    	DB::table('validations')->insert([
	    		'reference' => 'certificate',
	    		'hash' => $hash,
	    		'cpf' => $student->cpf,
	    		"created_at" =>  \Carbon\Carbon::now(),
            	"updated_at" => \Carbon\Carbon::now(),
	    	]);


		    $file = Storage::disk('certificados')->get('/templates/' . $certificate->template . '.png');


			return \PDF::loadView('estudante.certificados.show', 
				compact('certificate', 'student', 'file', 'url', 'today', 'now', 'eventDay', 'hash'))
				->setPaper('a4', 'landscape')
		        ->stream('certificado-sga.pdf');
	    }
	}
	public function hashValidator() {
		return view('estudante.certificados.validate');
	}
	public function hashValidate(Request $request) {
		$result = DB::table('validations')->where('hash', $request->hash)->get();
		return response(['success' => true, 'validation' => $result]);

	}
}
