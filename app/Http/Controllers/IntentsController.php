<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adjustment;


class IntentsController extends Controller
{
    public function show()
    {
        return view('ajuste.login');
    }

    public function loginAdjustments()
    {
        if(!Adjustment::isOpen()){
            return redirect('/login')->withErrors(['Ajuste indisponível, aguarde abertura.']);
        }

        //botão "ajuste do plano de estudos"
        if(request()->has(['cpf', 'matricula']))
        {
            return redirect('/ajuste')->with([
                'cpf' => request()->cpf,
                'matricula' => request()->matricula
            ]);
        }
        return redirect('/login');
    }

    public function loginCertificates()
    {
        //botão "emissão de certificados"
        if(request()->has(['cpf', 'matricula']))
        {
            return redirect('/certificados')->with([
                'cpf' => request()->cpf,
                'matricula' => request()->matricula
            ]);
        }
    }

}
