<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Adjustment;
use App\ConfigAdjustment;

class ViewsController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth_student');
    }
    
    public function getView() 
    {
        $availableViews = [
            'home' => 'estudante.home',
            'meus-dados' => 'estudante.meus-dados',
            'ajuste' => 'estudante.ajuste.index',
            'certificados' => 'estudante.certificados.index',
            'atualizar' => 'estudante.home',
            'eventos' => 'estudante.eventos.index',
        ];
    	$view = request('view');

        if($view == 'ajuste' && !Adjustment::isOpen()) {
            return response()->json(['errors' => ['Aguarde período de ajuste.']], 404);
        } 
        else if($view == 'certificados') {
            $matricula = Auth::guard('student')->user()->matricula;
            $events = Event::findEvents($matricula);

            if(!$events) {
                return response()->json(['errors' => ['Nenhum certificado localizado.']], 404);
            }
            $html = view($availableViews[$view], compact('events'))->render();
            return array('success' => true, 'html' => $html);
        }

    	$html = view($availableViews[$view])->render();
    	return array('success' => true, 'html' => $html);
    }
}
