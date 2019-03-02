<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Adjustment;
use App\Subject;
use Carbon\Carbon;
use Validator;
use App\ConfigAdjustment;
use App\Mail\AdjustmentSent;


class AdjustmentsController extends Controller
{

	public function __construct()
	{
        $this->middleware('auth_student');
    }

    //Mostrar o formulário de ajuste
    public function show()
    {
        return view('estudante.ajuste.show');
    }

    public function modify(Request $request)
    {
        /*return response()->json(array(
                'request' => $request,
            ));*/

        $html = view('estudante.ajuste.index', compact('request'))->render();
        return array('success' => true, 'html' => $html);
    }


    public function confirm(Request $request)
    {   

        $validator = $this->validateAdjustment();

        if($validator->fails()) 
        {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        $html = view('estudante.ajuste.confirm', compact('request'))->render();

        return array('success' => true, 'html' => $html);
    }

    public function store(Request $request) {
        
        $adjustment = Adjustment::store($request);
        
        $attributes = [
            'periodo-ajuste' => $request['periodo-ajuste'],
            'disciplina-ajuste' => $request['disciplina-ajuste'],
            'acao-ajuste' => $request['acao-ajuste']
        ];

        //disparar e-mail!
        \Mail::to($request['email'])->send(new AdjustmentSent($attributes));



        $html = view('estudante.ajuste.success')
            ->with([
                'success' => 'Requerimento enviado com sucesso para análise pelo SGA. 
                              Recomenda-se que o aluno imprima/salve este 
                              comprovante e acompanhe o resultado pelo idUFF.',
                'userInput' => 
                [
                    'nome' => $request['nome'],
                    'cpf' => $request['cpf'],
                    'matricula' => $request['matricula'],
                    'email' => $request['email'],
                    'tel' => $request['tel'],
                    'disciplina' => $request['disciplina-ajuste'],
                    'periodo' => $request['periodo-ajuste'],
                    'requerimento' => $request['acao-ajuste'],
                    'resultado' => 'Pendente',
                    'autenticacao' => $adjustment['autenticacao'],
                    'datahora' => $adjustment['dataHora']
                ]
            ])
            ->render();

        return array('success' => true, 'html' => $html);
    }

    public function success()
    {
        if(session()->has(['success', 'userInput']))
        {
            //dd(session('userInput'));
            return view('estudante.ajuste.success')->with([
                'success' => session('success'),
                'userInput' => session('userInput')
            ]);
        }
        return redirect('/login')->with('erros', 'Requerimento não realizado. Entre em contato com o SGA');
    }



    public function validateAdjustment()
    {

        $validator = Validator::make(request()->all(), [
            'nome' => ['required', 'min:5'],
            'cpf' => ['required', 'min:11'],
            'matricula' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'periodo-ajuste' => 'required|array',
            'periodo-ajuste.*' => 'required',
            'disciplina-ajuste' => 'required|array',
            'disciplina-ajuste.*' => 'required',
            'acao-ajuste' => 'required|array',
            'acao-ajuste.*' => 'required',
        ]);
        return $validator;
    }

}
