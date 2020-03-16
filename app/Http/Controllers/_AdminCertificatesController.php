<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificate;
use App\Event;
use App\Template;
use App\Student;

class AdminCertificatesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index() {
        $certificates = Certificate::with('event')->get();
        return view('admin.certificados.index', compact('certificates'));
    }

    public function create() {
        $events = Event::all();
        $templates = json_encode(Template::listNames());
        $certificates = count(Event::all()) ? Event::first()->certificates : json_encode([]);
        return view('admin.certificados.create', compact('events', 'templates', 'certificates'));
    }

    public function store(Request $request) {
        $attributes = $request->validate([
            'event_id' => 'required',
            'template' => 'required',
            'cpf' => 'required',
            'attendant_name' => 'required',
            'email' => '',
            'matricula' => '',
        ]);

        $exists = Certificate::where(['event_id' => $attributes['event_id'], 'cpf' => $attributes['cpf']])
            ->first();

        if($exists) return response(
            ['status' => false, 
             'message' => 'Já existe certificado deste evento para o cpf informado.'], 403);

        $result = Certificate::create($attributes);
        return response(
            ['status' => true, 
             'message' => 'Certificado emitido com sucesso.'], 200);
    }
    public function certificates(Event $event) {
        $certificates = Certificate::where('event_id', $event->id)->latest()->get()
            ->map(function($certificate) {
                return array(
                    'nome' => $certificate->attendant_name,
                    'email' => $certificate->email,
                    'matricula' => $certificate->matricula,
                    'cpf' => $certificate->cpf
                );
            });
        return response(['status' => true, 'certificates' => $certificates], 200);
    }


    public function show() {
    	return "AdminCertificatesController@show";
    }

    public function configure() {
    	return 'AdminCertificatesController@configure';
    }
}
