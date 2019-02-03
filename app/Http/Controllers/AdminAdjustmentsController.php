<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminAdjustment;
use App\Adjustment;

use Carbon\Carbon;

class AdminAdjustmentsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function show()
    {
        if(session()->has('adjustments')) {
            return view('admin.ajuste.show')->
                with([
                        'adjustments' => session('adjustments'),
                        'nome' => session('nome'),
                        'cpf' => session('cpf'),
                        'matricula' => session('matricula')
                    ]);            
        }

        //Mostra tudo
    	$adjustments = AdminAdjustment::show();


    	return view('admin.ajuste.show', compact('adjustments'));
    }

    public function filter(Request $request) 
    {
        $adjustments = '';
        $inputs = $request->except([
            '_token', 
            'data-requerimento-de', 
            'data-requerimento-ate']);

        $from = $request->has('data-requerimento-de') ? 
            Carbon::parse($request['data-requerimento-de'])->startOfDay() : false;
        $to = $request->has('data-requerimento-ate') ? 
            Carbon::parse($request['data-requerimento-ate'])->endOfDay() : false;

        //Caso insira nome, fazer uma query like
        if($request->has('nome')) 
        {
            unset($inputs['nome']);
            $adjustments = Adjustment::where('nome', 'like', '%' . $request['nome'] . '%')->get();

            //Para cada input restantes, filtrar
            foreach ($inputs as $key => $input) {
                $adjustments = $adjustments->where($key, $input);
            }
        }
        //Caso não coloque nome, utilizar todos os inputs enviados
        else $adjustments = Adjustment::where($inputs)->get();


        if($from && $to) {
            $adjustments = $adjustments->where('created_at', '>=', $from)
                                       ->where('created_at', '<=', $to);
        }

        //return view('admin.ajuste.show', compact('adjustments', 'request'));
        return redirect('/admin/ajuste')
                    ->with([
                        'adjustments' => $adjustments,
                        'nome' => request('nome'),
                        'cpf' => request('cpf'),
                        'matricula' => request('matricula')
                    ]);
    }

    public function defer(Request $request)
    {

        //dd($request);

        Adjustment::defer($request);

        //Em vez de redirecionar, fazer ajax
        //return redirect('/admin/ajuste');
    }

    public function deny(Request $request)
    {
        Adjustment::deny($request);
    }
    public function configure()
    {
        return 'AdminAdjustmentsController@configure';
    }


}
