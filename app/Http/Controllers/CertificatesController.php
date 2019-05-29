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
		$this->middleware('auth_student')->except(['hashValidator', 'hashValidate']);
	}
	public function print(Certificate $certificate) {
	    $student = Auth::guard('student')->user();

	    abort_unless(($certificate->cpf == $student->cpf), 403);

	    $hash = substr(md5(uniqid(rand(), true)), 16, 16);

	    $template_url = Storage::url('certificados/templates/' . $certificate->template . '.png');

	    $validation_url = 'http://aplicacoes.sga.uff.br/certificado/validar?hash=' . $hash . '&source=qrcode';
	    //$validation_url = 'http://192.168.0.156:8000/certificado/validar?hash=' . $hash . '&source=qrcode';

	    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		$today = strftime('%d de %B de %Y', strtotime('today'));
		$eventDay = strftime('%d de %B de %Y', strtotime($certificate->event->data));
		$now = date('H:i:s');


		//$qrCode = \QrCode::generate('Make me into a QrCode!');
		//dd($qrCode);

	    $exists = Storage::disk('certificados')->exists('/templates/' . $certificate->template . '.png');
	    if($exists) {
	    	DB::table('validations')->insert([
	    		'reference' => 'certificate',
	    		'hash' => $hash,
	    		'cpf' => $student->cpf,
	    		"created_at" =>  \Carbon\Carbon::now(),
            	"updated_at" => \Carbon\Carbon::now(),
	    	]);
	    	//return view('estudante.certificados.qr-test', compact('certificate', 'student', 'template_url', 'today', 'now', 'eventDay', 'hash'));
			return \PDF::loadView('estudante.certificados.show', 
				compact('certificate', 'student', 'template_url', 'validation_url', 'today', 'now', 'eventDay', 'hash'))
				->setPaper('a4', 'landscape')
		        ->stream('certificado-sga.pdf');
	    }
	}
	public function hashValidator(Request $request) {
		$hash = $request->hash;
		$source = $request->source;
		$result = ['validation' => DB::table('validations')->where('hash', $hash)->get(),
				   'hash' => $hash];
	    $result = json_encode($result);
		//dd($result);
		//.../validar?hash=123&source=string -> response
		//.../validar?hash=123&source=qrcode -> view->with
		//.../validar?hash=123				 -> view->with
		//.../validar/						 -> view->with

		//dd($request->hash, $request->source);
		//dd($result);
		if($hash && ($source == 'string')) {
			return $result;
		} 
		return view('estudante.certificados.validate', compact('result'));
		


	}
}
