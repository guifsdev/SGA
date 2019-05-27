<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Template;


class EventsController extends Controller
{
	public function __construct()
	{
    	//$this->middleware('auth_student');
		
	}

    public function index()
    {
    	$events = Event::all();
    	return view('admin.eventos.index', compact('events'));
    }

    public function show(Event $event)
    {
    	return view('admin.eventos.show', compact('event'));
    }


    public function edit(Event $event)
    {
    	Event::findOrFail($event->id);
    	$templates = Template::listNames();
    	return view('admin.eventos.edit', compact('event'));
    }

    public function update(Event $event)
    {
        $attributes = $this->validateEventAttributes();
        $event->update($attributes);

        return response([
            'success' => true, 
            'message' => 'Evento atualizado com sucesso.']);
    }

    public function store(Request $request) {
		$attributes = $this->validateEventAttributes();
    	$event = Event::create($attributes);

        return response([
            'success' => true,
            'message' => 'Evento criado com sucesso.',]);
    }

    public function formatParticipants($insertionMethod) {

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
		]);
    }

    public function create()
    {
        //$templates = $this->getTemplateList();
    	$templates = Template::listNames();
        
    	//dd($templates);

    	return view('admin.eventos.create', compact('templates'));
    }






}
