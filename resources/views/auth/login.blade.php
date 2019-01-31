@extends('layouts.master')

@section('title', 'SGA - Login do estudante')

@section('content')
<div class="container-fluid">
    <main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
    style="
        margin: 0 auto; 
        padding-left: 1rem !important;">

        <h3>Gerenciamento de Ajustes e Certificados</h3>

        <form method="POST" action="/admin/login">
            {{csrf_field()}}
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
    </main>
</div>




@endsection
