@extends('layouts.master')
@section('title', 'SGA - Login do estudante')

@section('content')
<form method="POST" action="/estudante/login" class="form-signin">
    {{csrf_field()}}
    <h1 class="h3 mb-3 font-weight-normal">Login do Estudante</h1>
    
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" placeholder="CPF" name="cpf" required>
    </div>

    <!-- <div class="form-group">
        <label for="matricula">Matrícula:</label>
        <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" name="matricula" >
    </div> -->
    <div class="form-group">
        <button id="ajuste" type="submit" class="btn btn-lg btn-primary btn-block" aria-describedby="aviso">Login</button>
        <!-- <button id="ajuste" type="submit" class="btn btn-lg btn-primary btn-block" aria-describedby="aviso">Ajuste do plano de estudos</button>
        <button id="certificados" type="submit" class="btn btn-lg btn-primary btn-block" aria-describedby="aviso">Emissão de certificados</button> -->
    </div>
    <small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
    @include('ajuste.errors')

    @if(session()->has('no_certificates'))
    <div class="form-group alert alert-warning" role="alert">
      {{session('no_certificates')}}
    </div>
    @endif
</form>

@section('custom_styles')
<!-- Custom Signin Template for Bootsrap -->
<link rel="stylesheet" href="{{asset('css/signin.css')}}">
@endsection

@section('custom_scripts')
<!-- <script type="text/javascript" src="{{ asset('js/jquery.maskedinput-1.1.4.pack.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>

@endsection

<script type="text/javascript">
/*$(document).ready(function() {
    $("#cpf").mask("999.999.999-99");
    $('button[type=submit]').on('click', chooseRoute);

});*/
</script>

@endsection
