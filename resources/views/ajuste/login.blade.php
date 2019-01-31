@extends('layouts.master')

@section('title', 'SGA - Login do estudante')

@section('content')
<div class="container">
    <div class="container-fluid">
        <main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
        style="
            margin: 0 auto; 
            padding-left: 1rem !important;">
    
        <h3>Ajuste de disciplinas do aluno</h3>
    
        <form method="POST" action="/ajuste/login">
            {{csrf_field()}}
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" required>
            </div>
    
            <div class="form-group">
                <label for="matricula">Matrícula:</label>
                <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" name="matricula" >
            </div>
            <div class="form-group align-center">
                <button id="ajuste" type="submit" class="btn btn-primary" aria-describedby="aviso">Ajustar do plano de estudos</button>
            </div>
            <div class="form-group align-center">
                <button id="certificados" type="submit" class="btn btn-primary" aria-describedby="aviso">Emissão de certificados</button>
            </div>
            <small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
    
            @include('ajuste.errors')
            </main>
        </form>
    </div>
</div>

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
