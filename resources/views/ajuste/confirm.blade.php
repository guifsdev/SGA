@extends('layouts.master')

@section('title', 'SGA - Ajuste de disciplinas')

@section('content')

<div class="container-fluid">
	<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
	style="
		margin: 0 auto; 
		padding-left: 1rem !important;">


	<h3>Ajuste de disciplinas do aluno</h3>
	<form method="POST" action="/ajuste/salvar">
	{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input disabled="disabled" type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" value="{{request('nome')}}" >
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input disabled="disabled" type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" value="{{request('cpf')}}" >
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input disabled="disabled" type="text" class="form-control" id="matricula" placeholder="Sua matrícula" value="{{request('matricula')}}" name="matricula" >
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input disabled="disabled" type="email" class="form-control" id="email" name="email" value="{{request('email')}}" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input disabled="disabled" type="tel" class="form-control" id="telefone" name="tel" value="{{request('tel')}}" >
		</div>
			<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col" style="width: 20%">Período</th>
			      <th scope="col">Disciplina</th>
			      <th scope="col">Requerimento</th>
			    </tr>
			  </thead>
			  <tbody>
				@for($i = 1; $i <= count(request('periodo-ajuste')); ++$i)
					<tr class="ajuste" id="{{$i}}">
					  <td scope="row">
					  	<input name="periodo-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('periodo-ajuste')[$i]}}">
					  </td>
					  <td>
					  	<input name="disciplina-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('disciplina-ajuste')[$i]}}">
					  </td>
					  <td style="width: 5%" class="align-radio-center">
					  	<input name="acao-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('acao-ajuste')[$i]}}">
					  </td>
					  <td style="width: 5%" class="align-radio-center">
					  </td>
					</tr>
				@endfor
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button type="submit" class="btn btn-primary" aria-describedby="aviso" id="confirmar">Confirmar</button>
				<button type="submit" class="btn btn-secondary" aria-describedby="aviso" id="modificar">Modificar</button>
			</div>	
		</main>
	</form>
	
	<!-- Botão modificar  -->
	<!-- <form method="POST" action="/ajuste/modificar">
		{{csrf_field()}}	
		<div class="form-group align-center">
		</div>
	</form> -->
	@include('ajuste.errors')
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
			if(btn.attr('id') === 'modificar')
			{
				$('form').attr('action', '/ajuste/modificar');
			}

		}


		function reenableInputs() {
			var disabledInputs = $('input:disabled');
			disabledInputs.prop('disabled', false);
		}
	});
</script>
@endsection

