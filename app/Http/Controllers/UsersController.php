<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UsersController extends Controller
{
	public function __construct() {
		$this->middleware('admin');
	}

    public function show()
    {
    	//return "UsersController@show";
    	$users = User::all();

    	//dd($users);
    	return view('admin.usuarios.show', compact('users'));
    }

    public function create()
    {
    	return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        /*$attributes = $request->user
            ->validate([
                'name' => 'required',
                'email' => 'required',
                'is_admin' => ['required', 'boolean'],
                'cpf' => 'required',
                'password' => 'required'
            ]);*/

        $attributes = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'is_admin' => ['required', 'boolean'],
            'cpf' => 'required',
            'password' => 'required'
        ])->validate();

        $attributes['password'] = bcrypt(request('password'));

        //dd($attributes);
        $exists = User::where('cpf', $attributes['cpf'])->first();
        if($exists) return response(['status' => false, 'message' => 'Já existe usuário para o cpf informado.'], 403);

        User::create($attributes);

        return response(['status' => true, 'message' => 'Usuário criado com successo.'], 200);

        //return redirect('/admin/usuarios');
    }
}
