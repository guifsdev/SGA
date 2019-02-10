<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventsController extends Controller
{
	public function __construct()
	{
    	$this->middleware('auth')->except('certificate');
		
	}

    public function index()
    {
    	$events = Event::all();
    	return view('admin.eventos.index', compact('events'));
    }

    public function show(Event $event)
    {
    	//dd($event);
    	return view('admin.eventos.show', compact('event'));
    }


    public function edit(Event $event)
    {
    	Event::findOrFail($event->id);
    	$templates = $this->getTemplates();

    	return view('admin.eventos.edit', compact('event', 'templates'));
    }

    public function update(Event $event)
    {
    	$attributes = $this->validateEventAttributes();

    	$attributes['participantes'] = 
			$this->formatParticipants(request('insertion-method'));
		$event->update($attributes);
		return redirect('admin/eventos')->with(['success' => 'Evento atualizado com sucesso.']);
    }



    public function store(Request $request)
    {

		$attributes = $this->validateEventAttributes();
    	
		$attributes['participantes'] = 
			$this->formatParticipants($request['insertion-method']);

    	$event = Event::create($attributes);

		return redirect('admin/eventos')->with(['success' => 'Evento criado com sucesso.']);
    }

    public function formatParticipants($insertionMethod) 
    {

    	if($insertionMethod == 'csv') {
    		request()->validate(['file-contents' => 'required']);

			$csv = request('file-contents');
	        $participants = array_map("str_getcsv", explode("\n", $csv));
	        //dd($csv, $participants);
	        $output = [];

	        foreach ($participants as $key => $participant) {
	            if($key == 0) continue;

	            $data = ['nome', 'cpf', 'matricula', 'email'];
	            $values = [];
	            foreach ($participant as $key => $value) {
	                array_push($values, $value);
	            }
	            array_push($output, array_combine($data, $values));
	        }

	        $jsonFormat = json_encode($output);
	        return $jsonFormat;
    	}

    	else if($insertionMethod == 'manual') {
			request()->validate([
                'nome-participante' => 'required',
                'cpf-participante' => 'required',
                'matricula-participante' => 'required',
                'email-participante' => 'required'
            ]);
	        
	        $output = [];

	        for ($i = 0; $i < count(request('nome-participante')); $i++) { 
	            # code...
	            $data = [
	                'nome' => request('nome-participante')[$i],
	                'cpf' => request('cpf-participante')[$i],
	                'matricula' => request('matricula-participante')[$i],
	                'email' => request('email-participante')[$i],
	            ];
	            array_push($output, $data);
	        }

	        $jsonFormat = json_encode($output);
	        return $jsonFormat;
    	}
    }

    public function validateEventAttributes()
    {
		return request()->validate([
			'nome' => 'required',
			'descricao' => 'required',
			'local' => 'required',
			'data' => 'required',
			'tipo' => 'required',
			'duracao' => 'required',
			'carga_horaria' => 'required',
			'organizador' => 'required',
			'template' => 'required',
		]);
    }

    public function certificate(Event $event)
    {
    	$template = 'certificados.templates.' . $event['template'];
    	$participant = [
    		'nome' => request('nome'),
    		'email' =>  request('email'),
    		'cpf' => request('cpf'),
    		'matricula' => request('matricula')
    	];
    	return \PDF::loadView('certificados.show', compact('event', 'template','participant'))
    		->stream('certificado-sga.pdf');
    }

    public function create()
    {
    	$templates = $this->getTemplates();
    	//dd($templates);

    	return view('admin.eventos.create', compact('templates'));
    }
    public function getTemplates()
    {
		$files = Storage::disk('views')->files('certificados/templates');
		//if(count($files) == 0)

		foreach ($files as $key => $file) {
			$fullName = explode('/', $file);
			$name = explode('.', $fullName[count($fullName)-1])[0];
			$files[$key] = $name;
		}

		return $files;

    }
}
