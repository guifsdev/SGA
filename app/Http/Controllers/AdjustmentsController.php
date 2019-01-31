<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;
use Carbon\Carbon;


class AdjustmentsController extends Controller
{

	public function __construct()
	{

    }

    //Mostrar o formulário de ajuste
    public function show()
    {
        if(!session()->has(['cpf', 'matricula']))
        {
            //redirectiong to login page with errors
            if(session()->has('errors'))
            {
                return redirect('/login')->with([
                    'errors' => session('errors')
                ]);
            }
            if(session()->has('modify'))
            {
                //dd(session('userInput'));
                return view('ajuste.show')->with([
                    'userInput' => session('userInput')
                ]);
            }
            return redirect('/login');
        }
        return view('ajuste.show');
    }

    public function confirm(Request $request)
    {
        //dd(count($request['periodo-ajuste']));
        $this->isValidAdjustment();
        return view('ajuste.confirm', compact('request'));
    }



    public function store() {
        $autenticacao = md5(uniqid(rand(), true));
        $dataHora = Carbon::now();

        //dd($autenticacao);
        for($i = 1; $i <= count(request('periodo-ajuste')); ++$i)
        {
            Adjustment::create([
                'nome' => request('nome'),
                'cpf' => request('cpf'),
                'matricula' => request('matricula'),
                'email' => request('email'),
                'tel' => request('tel'),
                'disciplina' => request('disciplina-ajuste')[$i],
                'periodo' => request('periodo-ajuste')[$i],
                'requerimento' => request('acao-ajuste')[$i],
                'resultado' => 'Pendente',
                'autenticacao' => $autenticacao
            ]);
        }

        //return redirect('/login')->with('success', 'Requerimento realizado com sucesso.');
        return redirect('/ajuste/sucesso')->with([
            'success' => 'Requerimento enviado com sucesso para análise pelo SGA. 
                          Recomenda-se que o aluno imprima/salve este comprovante.',
            'userInput' => [
                'nome' => request('nome'),
                'cpf' => request('cpf'),
                'matricula' => request('matricula'),
                'email' => request('email'),
                'tel' => request('tel'),
                'disciplina' => request('disciplina-ajuste'),
                'periodo' => request('periodo-ajuste'),
                'requerimento' => request('acao-ajuste'),
                'resultado' => 'Pendente',
                'autenticacao' => $autenticacao,
                'datahora' => $dataHora


            ]
        ]);
    }

    public function success()
    {
        if(session()->has(['success', 'userInput']))
        {
            //dd(session('userInput'));
            return view('ajuste.success')->with([
                'success' => session('success'),
                'userInput' => session('userInput')
            ]);
        }
        return redirect('/login')->with('erros', 'Requerimento não realizado. Entre em contato com o SGA');
    }

    public function modify(Request $request)
    {
        //dd($request);
        return redirect('/ajuste')->with([
            'modify' => true,
            'userInput' => [
                'nome' => request('nome'),
                'cpf' => request('cpf'),
                'matricula' => request('matricula'),
                'email' => request('email'),
                'tel' => request('tel'),
                'disciplina' => request('disciplina-ajuste'),
                'periodo' => request('periodo-ajuste'),
                'requerimento' => request('acao-ajuste'),
                'resultado' => 'Pendente'
            ]
        ]);
    }

    public function isValidAdjustment()
    {
        //dd(request());
        //validate base attributes
        $baseAttributes = request()->
            validate([
                'nome' => ['required', 'min:5'],
                'cpf' => ['required', 'min:11'],
                'matricula' => 'required',
                'email' => 'required',
                'tel' => 'required'
            ]);

        request()->validate([
            'periodo-ajuste' => 'required',
            'disciplina-ajuste' => 'required',
            'acao-ajuste' => 'required'
        ]);
    }

}
