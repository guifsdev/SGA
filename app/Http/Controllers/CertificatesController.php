<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificatesController extends Controller
{
	//Mostrar lista de certificados
    public function show()
    {
        if(session()->has(['cpf', 'matricula']))
        {
        	return view('certificados.show');
        }
        return redirect('/login');
    }
}
