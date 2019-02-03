@extends('layouts.master')

@section('custom_styles')
<!-- Custom Signin Template for Bootsrap -->
<link rel="stylesheet" href="{{asset('css/signin.css')}}">
@endsection


@section('title', 'SGA - Login do estudante')
@section('content')
<form method="POST" action="/ajuste/login" class="form-signin">
    {{csrf_field()}}
    <h1 class="h3 mb-3 font-weight-normal">Ajuste de disciplinas do aluno</h1>
    
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" required>
    </div>

    <div class="form-group">
        <label for="matricula">Matrícula:</label>
        <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" name="matricula" >
    </div>
    <div class="form-group">
        <button id="ajuste" type="submit" class="btn btn-lg btn-primary btn-block" aria-describedby="aviso">Ajustar do plano de estudos</button>
        <button id="certificados" type="submit" class="btn btn-lg btn-primary btn-block" aria-describedby="aviso">Emissão de certificados</button>
    </div>
    <small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>

    @include('ajuste.errors')
</form>

<script type="text/javascript">
    $(document).ready(function() {

        var submitBtn = $('button:submit');

        submitBtn.click(function(e){
            //e.preventDefault();
            reenableInputs();
            changeFormAction($(this));
        });

        function changeFormAction(btn)
        {
            if(btn.attr('id') === 'ajustes')
            {
                $('form').attr('action', '/ajuste/login');
            }
            else if(btn.attr('id') === 'certificados')
            {
                $('form').attr('action', '/certificados/login');

            }


        }


        function reenableInputs() {
            var disabledInputs = $('input:disabled');
            disabledInputs.prop('disabled', false);
        }
    });
</script>

@endsection
