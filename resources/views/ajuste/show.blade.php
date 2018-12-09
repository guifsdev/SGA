@extends('layouts.master')

@section('content')

<h1>Ajustando...</h1>

<div class="container-fluid">
	<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
	style="
		margin: 0 auto; 
		padding-left: 1rem !important;">



	<form method="POST" action="/ajuste">
		{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" required>
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" required>
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" name="matricula" required>
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" required>
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" required>
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
			<div class="form-group">
				<button type="submit" class="btn btn-primary" aria-describedby="aviso">Ajustar plano de estudos</button>
				<small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
			</div>

		</main>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
	var row;

	//Queries triggers when selecting periodo from dropdown
	$('.periodo').change(function() {
		row = $(this).parent().parent();

		var rowId = row.attr('id');

		//console.log("rowId selecionado: " + rowId);

	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	        }
	    });

		//Saber qual periodo foi selecionado
		//var periodo = $(this).find(':selected').text();
		var periodo = row.find('.periodo :selected').text();
		//console.log('Periodo: ' + periodo);

		//Limpar conteudo da coluna de disciplinas
		var colDisciplinas = row.find('.disciplina');
		colDisciplinas.html('');

		//Coletar as disciplinas do periodo selecionado
		$.ajax({
			url: "{{ url('/disciplinas') }}",
			type: 'POST',
			data: {
				'periodo' : periodo
			},
			dataType: 'JSON',
			success: function(response) {
				for(var i = 0; i < response.length; ++i) {
					colDisciplinas.
					append('<option>' + response[i]['nome'] + '</option>');
				}
			},
			error: function(data) {
				console.log("Error: " + JSON.stringify(data));
			}
		});
	});
});
</script>


@endsection