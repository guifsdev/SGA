<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Requerimento;
use App\Consulta;

use DB;

class RequerimentosController extends Controller
{

    public function existir($email, $matricula) {
        //Verify if requerimento exists...
        $exists = Requerimento::where([
            ['email', '=', $email],
            ['matricula', '=', $matricula]
        ])->exists();

        if($exists) return true;

        return false;

        //If exists verify status

        //If not exists flash message that does not exist
    }

    public function consultar(Request $request) {
        if($this->existir($request->input('email'), $request->input('matricula'))) {
            $request->session()->flash('alert-warning', 'Requerimento existente.');
            
            //Registrar informações da consulta
            $token = md5(uniqid(rand(), true));
            $consulta = new Consulta();
            $consulta->add($request->input('matricula'), $token);

            $requerimentos = Requerimento::all();

            //Redirect to a displaying page
            return view('requerimentos.show', compact(['requerimentos', 'token']));

            //Display status
            
        }

        else $request->session()->flash('alert-warning', 'Requerimento inexistente.');

        return redirect()->home();

    }

    public function adicionar(Request $request) {

        //Validate inputs
        $this->validate($request,[
            'nome' => 'required',
            'cpf' => 'required',
            'matricula' => 'required'
        ]);


        $email = $request->input('email');
        $matricula = $request->input('matricula');


        //If already exists...
        if($this->existir($email, $matricula)) 
            $request->session()->flash('alert-warning', 'Requerimento já existe.');

        else {
            $requerimento = new Requerimento();

            //dd(DB::getQueryLog());
            //INSERT into table requerimentos
            for($i = 1; $i <= count($request->input('periodo-ajuste')); $i++) {
                $requerimento->create([
                    'nome' => $request->input('nome'),
                    'email' => $request->input('email'),
                    'matricula' => $request->input('matricula'),
                    'disciplina' => $request->input('disciplina-ajuste')[$i],
                    'periodo' => $request->input('periodo-ajuste')[$i],
                    'acao' => $request->input('acao-ajuste')[$i],
                    'status' => 'Aguardando',
                ]);
                
            }
            //On success, flash message
            $request->session()->flash('alert-success', 'Requerimento realizado com sucesso.');
        }

        return redirect()->home();

        //factory('App\Requerimento')->create();



      //dd(count($request->input('periodo-ajuste')));
    }
}