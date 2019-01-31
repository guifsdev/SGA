@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Ajustes')

@section('content')

<h3 class="align-center">Gerenciamento de Ajustes</h3>

<hr>

<div class="container-fluid admin-ajuste">
	<div id="filtros" class="container-fluid">
		<h4>Filtros <button class="btn btn-light toggle-collapse-btn" id="filtros-collapse-btn"><i class="fa fa-minus-square-o"></i></button></h4>

			<div id="filtros-container">
				<form method="POST" action="/admin/ajuste/filtrar" class="form-group" id="filtro">
					{{csrf_field()}}
					<div class="grupo-filtro">
						<input id="nome-check" type="checkbox"/><label class="fixed-width-labels" for="nome-check">Nome:</label>
						<input type="text" class="form-control input-filtros" id="nome" name="nome">
					</div>
					
					<div class="grupo-filtro"><input id="cpf-check" type="checkbox"/><label class="fixed-width-labels" for="cpf-check">CPF:</label>
						<input type="text" class="form-control input-filtros" id="cpf" name="cpf">	
					</div>
					
					<div class="grupo-filtro">
						<input id="matricula-check" type="checkbox"/><label class="fixed-width-labels" for="matricula-check">Matricula:</label>
						<input type="text" class="form-control input-filtros" id="matricula" name="matricula">
					</div>
					
					<div class="grupo-filtro">
						<input id="resultado-check" type="checkbox"/><label class="fixed-width-labels" for="resultado-check">Resultado:</label>
						<select class="custom-select custom-select-sm input-filtros" name="resultado" id="">
							<option value="Todos">Todos</option>
							<option value="Pendente">Pendente</option>
							<option value="Deferido">Deferido</option>
							<option value="Indeferido">Indeferido</option>
						</select>
					</div>
					<div class="grupo-filtro">
						<input id="periodo-check" type="checkbox"/><label class="fixed-width-labels" for="periodo-check">Periodo:</label>
						<select class="custom-select custom-select-sm input-filtros" name="periodo">
							<option value="">Todos</option>
							<option value="">1</option>
							<option value="">2</option>
							<option value="">3</option>
							<option value="">4</option>
							<option value="">5</option>
							<option value="">6</option>
							<option value="">7</option>
							<option value="">8</option>
						</select>
					</div>
					
					<div class="grupo-filtro">
						<input id="disciplina-check" type="checkbox"/><label class="fixed-width-labels" for="disciplina-check">Disciplina:</label>
						<select class="custom-select custom-select-sm input-filtros" name="disciplina">
							<option value="">Todas</option>
						</select>
					</div>
					
					<div class="grupo-filtro">
						<input id="data-requerimento-check" type="checkbox"/><label class="fixed-width-labels" for="data-requerimento-check">Data requerimento</label>
						<label for="requerimento-de">de:</label>
						<input type="date" name="data-requerimento-de" id="data-requerimento-de" class="data-requerimento input-filtros">
						<label for="requerimento-de">até:</label>
						<input type="date" name="data-requerimento-ate" class="data-requerimento input-filtros">
					</div>
					<button type="submit" class="btn btn-primary" id="deferir-btn">Aplicar</button>
					<button type="button" class="btn btn-secondary" id="deferir-btn" >Limpar</button>
				</form>
			
				
				<hr>
				<div id="filtro-rapido" class="container-fluid">
					<h5>Filtrar linhas <button class="btn btn-light toggle-collapse-btn" id="filtro-rapido-collapse-btn"><i class="fa fa-minus-square-o"></i></button></h5> 
					<div class="collapse-filtro-rapido" id="filtro-rapido-container">
						
						
						<div class="grupo-filtro">
							<label class="fixed-width-labels" for="nome-check">Procurar por:</label>
							<input type="text" class="form-control input-filtros" id="procurar-por"
								placeholder="Nome, matricula, CPF, etc">
						</div>
					<!-- 
						<label class="fixed-width-labels" for="requerimento-de">Situação:</label>
						<select class="custom-select custom-select-sm input-filtros" name="filtro-rapido" id="">
							<option value="">Exibir pendentes</option>
							<option value="">Exibir deferidos</option>
							<option value="">Exibir indeferidos</option>
							<option value="">Exibir todos</option>
						</select>
						<button type="button" class="btn btn-primary" id="deferir-btn" >Aplicar</button> 
					-->
					</div>

				</div>		
			</div>
	</div>
	<hr>
	<div id="acoes"
		class="container-fluid">
		<h4>Ações <button class="btn btn-light toggle-collapse-btn" id="acoes-collapse-btn"><i class="fa fa-minus-square-o"></i></button></h4>
		
		<div id="acoes-container">
			<div id="">
				<label class="fixed-width-labels" for="disciplina-check">Motivo indeferir:</label>
				<select name="" class="custom-select custom-select-sm input-filtros" id="motivo-indeferir">
					<option value=""></option>
					<option value="vaga">Não há vagas</option>
					<option value="prerequisito">Não possui pré-requisito</option>
					<option value="horario">Horário em conflito</option>
					<option value="outro">Outro</option>
				</select>

				<div id="acoes-motivo" class="collapse">
					<label class="fixed-width-labels" for="acoes-motivo">Descrição:</label>
	   				<textarea class="form-control" id="acoes-motivo" rows="3"></textarea>
				</div>
			</div>

			<div id="acoes-btns">
				<button type="button" class="btn btn-success" id="deferir-btn" disabled>Deferir selecionados</button>
				<button type="button" class="btn btn-danger" id="indeferir-btn" disabled>Indeferir selecionados</button>
			</div>
		</div>
	</div>
	<hr>
	<div id="requerimentos" 
		class="container-fluid">
		<table class="table table-sm">
		  <thead>
		    <tr id="head">
	    	  <th>
	    	  	  <input id="bulk" type="checkbox"/><label for="bulk"></label>
	    	  </th>
		      <th scope="col">Nome</th>
		      <th scope="col">CPF</th>
		      <th scope="col">Matricula</th>
		      <th scope="col">Disciplina</th>
		      <th scope="col">Motivo indeferido</th>
		      <th scope="col">Requerimento</th>
		      <th scope="col">Data requerimento</th>
		      <th scope="col">Resultado</th>
		    </tr>
		  </thead>
	
		  <tbody>
			@foreach($adjustments as $pos => $adjustment)
				<tr>
					<th scope="row">
						<input id="check[{{$pos}}]" class="checkable" type="checkbox"/><label for="check[{{$pos}}]"></label>
					</th>	
					<td>{{$adjustment['nome']}}</td>	
					<td>{{$adjustment['cpf']}}</td>	
					<td>{{$adjustment['matricula']}}</td>	
					<td>{{$adjustment['disciplina']}}</td>	
					<td>{{$adjustment['motivo_indeferido']}}</td>	
					<td>{{$adjustment['requerimento']}}</td>	
					<td>{{$adjustment['created_at']}}</td>	
					<td>{{$adjustment['resultado']}}</td>	
				</tr>
			@endforeach
		  </tbody>
		</table>
	</div>
</div>



<script type="text/javascript" src="{{ asset('/js/my_functions.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {

	$('form#filtro').submit(function(form) {
		//form.preventDefault();
		sendFilterParams($(this));
		//form.submit();
	});




	$('select[name=periodo]').on('change', function() {
		buscarDisciplinas(route = '/admin/ajuste');
	});

	$('.toggle-collapse-btn').click(function() {
		toggleCollapse(this);
	});


	$('#motivo-indeferir').change({passive:true}, function() {
		//se select for != '' libera botão indeferir
		var indeferirBtn = $('#indeferir-btn');

		if(this.value === '') {
			indeferirBtn.prop('disabled', true);
		}
		else indeferirBtn.prop('disabled', false);



		//indeferirBtn.prop('disabled', false);
		explicarMotivoIndeferir(this);
		
	});

	$('#procurar-por').on('keyup', function() {
		var key = $(this).val().toLowerCase();
		filtrarTabela(key);
	});

	$('#bulk').on('change', bulkSelect);


	function toggleCollapse(item) {
		var id = $(item).attr('id');

		var filtrosContainer = $('#filtros-container');
		var filtroRapidoContainer = $('#filtro-rapido-container');
		var acoesContainer = $('#acoes-container');

		switch (id) {
			case 'filtros-collapse-btn': 
				filtrosContainer.hasClass('collapse') ? filtrosContainer.removeClass('collapse') : filtrosContainer.attr('class', 'collapse');
				break;
			case 'filtro-rapido-collapse-btn':
				filtroRapidoContainer.hasClass('collapse') ? filtroRapidoContainer.removeClass('collapse') : filtroRapidoContainer.attr('class', 'collapse');
				break;
			case 'acoes-collapse-btn':
				acoesContainer.hasClass('collapse') ? acoesContainer.removeClass('collapse') : acoesContainer.attr('class', 'collapse');
				break;
			default: console.log('none clicked');
		}
	}

	function explicarMotivoIndeferir(item) {
		var acoesMotivo = $('#acoes-motivo');
		if(item.value == 'outro') {
			acoesMotivo.hasClass('collapse') ? acoesMotivo.removeClass('collapse') : acoesMotivo.attr('class', 'collapse');
		}
		else acoesMotivo.addClass('collapse');
	}

	function bulkSelect()
	{
		var checkLinhas = $('.checkable').filter(function(){
			var row = $(this).closest('tr');
			if(row.css('display') === 'none') return false;
			else return true;
		});

		if($(this).is(':checked')) {
			//excluir os não visiveis

			if(!checkLinhas.is(':checked')) {
				checkLinhas.prop('checked', true);
			}
		}
		else checkLinhas.prop('checked', false);

	}

	function filtrarTabela(key) {
		$('#requerimentos tr:not(#head)').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(key) > -1)
		});
	}
});
</script>

@endsection