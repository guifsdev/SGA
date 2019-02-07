@extends('layouts.master')

@section('title', 'SGA - Ajuste de disciplinas')

@section('content')

<div class="container-fluid">
	<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
	style="
		margin: 0 auto; 
		padding-left: 1rem !important;">


	<h3>Ajuste de disciplinas do aluno</h3>
	<form method="POST" action="/ajuste/confirmar">
	{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" value="{{session()->has('userInput') ? $userInput['nome'] : ''}}" >
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" value="{{session()->has('userInput') ? $userInput['cpf'] : session('cpf')}}" disabled="disabled">
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
				name="matricula" disabled="disabled"
				value="{{session()->has('userInput') ? $userInput['matricula'] : session('matricula')}}">
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" 
				value="{{session()->has('userInput') ? $userInput['email'] : ''}}" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" 
				value="{{session()->has('userInput') ? $userInput['tel'] : ''}}" >
		</div>
			<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col" style="width: 20%">Período</th>
			      <th scope="col">Disciplina</th>
			      <th scope="col">Incluir</th>
			      <th scope="col">Excluir</th>

			    </tr>
			  </thead>
			  <tbody>
			  	@for($i = 1; $i <= env('MAX_NUM_AJUSTE'); ++$i)
					@include('ajuste.row')
				@endfor
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button type="submit" class="btn btn-primary" aria-describedby="aviso">Ajustar plano de estudos</button>
			</div>
			<small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
		</main>
	</form>
	@include('ajuste.errors')
</div>


<script type="text/javascript">
$(document).ready(function() {

	$('.periodo').on('change', function() {
		buscarDisciplinas('/ajuste', this);
	});


	$('form').submit(removeDisabledAttributes);

	function removeDisabledAttributes() 
	{
		var cpf = $('#CPF');
		var matricula = $('#matricula');

		cpf.prop('disabled', false);
		matricula.prop('disabled', false);
	}

});
</script>

@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
@endsection

