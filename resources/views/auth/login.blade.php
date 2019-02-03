@extends('layouts.master')

@section('title', 'SGA - Login do estudante')

@section('custom_styles')
<!-- Custom Signin Template for Bootsrap -->
<link rel="stylesheet" href="{{asset('css/signin.css')}}">
@endsection


@section('content')

<form method="POST" action="/admin/login" class="form-signin">
    {{csrf_field()}}

    <h1 class="h3 mb-3 font-weight-normal">Gerenciamento de Ajustes e Certificados</h1>

    <div class="form-group">
        <label for="matricula">Matricula do servidor:</label>
        <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" name="matricula" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" id="senha" placeholder="Senha" name="password" >
    </div>
    <div class="form-group align-center">
        <button type="submit" class="btn btn-primary" aria-describedby="aviso">Entrar</button>
    </div>

    @include('partials.errors')
</form>




@endsection
