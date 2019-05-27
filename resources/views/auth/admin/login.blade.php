@extends('layouts.master')

@section('title', 'SGA - Gerenciamento')

@section('custom_styles')
<!-- Custom Signin Template for Bootsrap -->
<link rel="stylesheet" href="{{asset('css/signin.css')}}">
@endsection


@section('content')

<form method="POST" action="/admin/login" class="form-signin">
    {{csrf_field()}}

    <h1 class="h3 mb-3 font-weight-normal" style="text-align: center;">Aplicações SGA</h1>
    <h3 class="h4 mb-3 font-weight-normal" style="text-align: center; color: gray">Gestão</h3>

    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" autocomplete="on" placeholder="Seu CPF" name="cpf" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" id="senha" placeholder="Senha" name="password" 
            autocomplete="current-password">
    </div>
    <div class="form-group align-center">
        <button type="submit" class="btn btn-primary" aria-describedby="aviso">Entrar</button>
    </div>

    @include('partials.errors')
</form>
@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#cpf').mask('000.000.000-00', {reverse: true});

    $('form').on('submit', function() {
        $('#cpf').unmask();
    })
});
</script>

@endsection





