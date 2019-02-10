<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;


class CertificatesController extends Controller
{


    public function index()
    {
        if(session()->has(['cpf', 'matricula']))
        {
            $cpf = session('cpf');
            $matricula = session('matricula');

            $events = Event::findEvents($matricula);

        	if(!$events)
        		return redirect('/login')->with(['no_certificates' => 'Nenhum certificado foi localizado para matrícula e CPF informados.']);

            $participant = $this->getParticipantData($events->first(), $matricula);

            //dd($events, $participant);

        	return view('certificados.index', compact('events', 'participant'));
        }
        return redirect('/login');
    }

    public function getParticipantData($event, $matricula)
    {
        $participants = json_decode($event['participantes'], true);

        $data = [];
        foreach ($participants as $participant) {
            if(in_array($matricula, $participant))
                $data = $participant;
        }
        return $data;
    }




    public function show()
    {
    }




}
