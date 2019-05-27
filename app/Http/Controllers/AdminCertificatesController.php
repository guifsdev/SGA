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
        //$certificates = Certificate::all();
        $certificates = Certificate::with('event')->get();
        return view('admin.certificados.index', compact('certificates'));
    }

    public function create() {
        $events = Event::all();
        $templates = Template::listNames();
        //$certificates = Certificate::all();
        $certificates = Event::first()->certificates;
        //$certificates = Event::with('student')->get();
        return view('admin.certificados.create', compact('events', 'templates', 'certificates'));
    }

    public function store(Request $request) {
        //return array('success' => true, 'request' => [$request['student_id'], $request['event_id'], $request['template']]);
        $attributes = $request->validate([
            'event_id' => 'required',
            'template' => 'required',
            'cpf' => 'required',
            'attendant_name' => 'required',
            'email' => '',
            'matricula' => '',
        ]);

        $result = Certificate::create($attributes);
        if($result) {
            return response(['success' => true, 'message' => 'Certificado emitido com sucesso'], 200);
        }

        //$certificate = new Certificate();
        //return $certificate->store($attributes);
    }
    public function certificates(Event $event) {
        $certificates = Certificate::where('event_id', $event->id)->get()
            ->map(function($certificate) {
                return array(
                    'nome' => $certificate->attendant_name,
                    'email' => $certificate->email,
                    'matricula' => $certificate->matricula,
                    'cpf' => $certificate->cpf
                );
            });
        return response(['success' => true, 'certificates' => $certificates], 200);
    }


    public function show()
    {
    	return "AdminCertificatesController@show";
    }

    public function configure()
    {
    	return 'AdminCertificatesController@configure';
    }
}
