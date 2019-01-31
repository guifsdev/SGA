<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntentsController extends Controller
{
    public function show()
    {
        return view('ajuste.login');
    }

    public function loginAdjustments()
    {
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
