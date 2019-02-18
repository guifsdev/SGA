@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Ajustes')
@section('nav_title', 'Gerenciamento de ajustes')

@section('content')

@section('custom_styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="{{asset('css/custom_checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/custom_datepicker.css')}}">
@endsection

@include('partials.menu')

<div class="container-fluid">
	<div class="admin-ajuste">
		<div id="filtros" class="container-fluid">
			<h4>Filtros <a class="btn btn-light toggle-collapse-btn" id="filtros-collapse-btn"><i class="fa fa-minus-square-o"></i></a></h4>
	
				<div id="filtros-container">
					<form method="POST" action="/admin/ajuste/filtrar" class="form-group" id="filtro">
						{{csrf_field()}}
						<div class="grupo-filtro">
							<input id="nome-check" type="checkbox"/><label class="fixed-width-labels" for="nome-check">Nome:</label>
							<input type="text" class="form-control input-filtros" id="nome" name="nome" 
								value="{{session()->has('nome') ? session('nome') : ''}}">
						</div>
						
						<div class="grupo-filtro"><input id="cpf-check" type="checkbox"/><label class="fixed-width-labels" for="cpf-check">CPF:</label>
							<input type="text" class="form-control input-filtros" id="cpf" name="cpf"
								value="{{session()->has('cpf') ? session('cpf') : ''}}">	
						</div>
						
						<div class="grupo-filtro">
							<input id="matricula-check" type="checkbox"/><label class="fixed-width-labels" for="matricula-check">Matricula:</label>
							<input type="text" class="form-control input-filtros" id="matricula" name="matricula"
								value="{{session()->has('matricula') ? session('matricula') : ''}}">
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
								<option value="Todos">Todos</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
							</select>
						</div>
						
						<div class="grupo-filtro">
							<input id="disciplina-check" type="checkbox"/><label class="fixed-width-labels" for="disciplina-check">Disciplina:</label>
							<select class="custom-select custom-select-sm input-filtros" name="disciplina">
								<option value="Todos">Todas</option>
							</select>
						</div>
						
						<div class="grupo-filtro">
							<input id="data-requerimento-check" type="checkbox"/><label class="fixed-width-labels" for="data-requerimento-check">Data requerimento</label>
							<label for="requerimento-de">de:</label>
							<input type="date" name="data-requerimento-de" id="data-requerimento-de" class="data-requerimento input-filtros">
							<label for="requerimento-de">até:</label>
							<input type="date" name="data-requerimento-ate" class="data-requerimento input-filtros">
						</div>
						<button type="submit" class="btn btn-primary">Aplicar</button>
						<button type="button" class="btn btn-secondary">Limpar</button>
					</form>
				
					
					<hr>
					<div id="filtro-rapido" class="container-fluid">
						<h5>Filtrar linhas <a class="btn btn-light toggle-collapse-btn" id="filtro-rapido-collapse-btn"><i class="fa fa-minus-square-o"></i></a></h5> 
						<div class="collapse-filtro-rapido" id="filtro-rapido-container">
							
							
							<div class="grupo-filtro">
								<label class="fixed-width-labels" for="nome-check">Procurar por:</label>
								<input type="text" class="form-control input-filtros" id="procurar-por"
									placeholder="Nome, matricula, CPF, etc">
							</div>
						</div>
	
					</div>		
				</div>
		</div>
		<hr>
		<form method="POST">
		{{csrf_field()}}
			<div id="acoes"
				class="container-fluid">
				<h4>Ações <a class="btn btn-light toggle-collapse-btn" id="acoes-collapse-btn"><i class="fa fa-minus-square-o"></i></a></h4>
				
				<div id="acoes-container">
					<div id="">
						<label class="fixed-width-labels" for="disciplina-check">Motivo indeferir:</label>
						<select name="motivo-indeferir" class="custom-select custom-select-sm input-filtros" id="motivo-indeferir">
							<option value=""></option>
							<option value="vaga">Não há vagas</option>
							<option value="pre-requisito">Não possui pré-requisito</option>
							<option value="horario-conflito">Horário em conflito</option>
							<option value="outro">Outro</option>
						</select>
		
						<div id="acoes-motivo" class="collapse">
							<label class="fixed-width-labels" for="acoes-motivo">Descrição:</label>
			   				<textarea name="motivo-descricao" class="form-control" id="acoes-motivo" rows="3"></textarea>
						</div>
					</div>
		
					<div id="acoes-btns">
						<button type="button" class="btn btn-success" id="deferir" disabled>Deferir selecionados</button>
						<button type="button" class="btn btn-danger" id="indeferir" disabled>Indeferir selecionados</button>
					</div>
				</div>
			</div> <!-- #acoes -->
			<div id="requerimentos" class="container-fluid">
				<table class="table table-sm">
					<thead>
					<tr id="head">
						  <th><input id="bulk" type="checkbox"/><label for="bulk"></label></th>
						  <th scope="col">Nº</th>
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
							<td>
								{{$adjustment['id']}}
								<input type="hidden" name="id[{{$pos}}]" value="{{$adjustment['id']}}">
							</td>
							<td>
								{{$adjustment['nome']}}
								<input type="hidden" name="nome[{{$pos}}]" value="{{$adjustment['nome']}}">
							</td>	
							<td>
								{{$adjustment['cpf']}}
								<input type="hidden" name="cpf[{{$pos}}]" value="{{$adjustment['cpf']}}">
							</td>	
							<td>
								{{$adjustment['matricula']}}
								<input type="hidden" name="matricula[{{$pos}}]" value="{{$adjustment['matricula']}}">
							</td>	
							<td>
								{{$adjustment['disciplina']}}
								<input type="hidden" name="disciplina[{{$pos}}]" value="{{$adjustment['disciplina']}}">
							</td>	
							<td>
								{{$adjustment['motivo_indeferido']}}
								<input type="hidden" name="motivo_indeferido[{{$pos}}]" value="{{$adjustment['motivo_indeferido']}}">
							</td>	
							<td>
								{{$adjustment['requerimento']}}
								<input type="hidden" name="requerimento[{{$pos}}]" value="{{$adjustment['requerimento']}}">
							</td>	
							<td>	
								{{$adjustment['created_at']}}
								<input type="hidden" name="created_at[{{$pos}}]" value="{{$adjustment['created_at']}}">
							</td>	
							<td>
								{{$adjustment['resultado']}}
								<input type="hidden" name="resultado[{{$pos}}]" value="{{$adjustment['resultado']}}">
							</td>	
						</tr>
						@endforeach
						</tbody>
				</table>
			</div> <!-- #requerimentos -->

		</form>
	</div> <!-- .admin-ajuste -->
</div>
@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('/js/my_functions.js') }}"></script>


<script type="text/javascript">
$(document).ready(function() {

	$('#acoes-btns button').on('click', function() {
		processarAjuste($(this));
	});

	//$('#bulk').on('change', bulkSelect);
	$(document).delegate('#bulk', 'change', bulkSelect);

	$('input[type=checkbox]').on('click', toggleActionButtons);




	$('#requerimentos').find('input[type=checkbox]').on('change', liberarDeferir);


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


	$('#motivo-indeferir').change(function() {
		//se select for != '' libera botão indeferir
		var indeferirBtn = $('#indeferir');
		var deferirBtn = $('#deferir');
		var checked = $('.checkable:checkbox:checked');
		
		//Temos mais pelo menos 1 selecionado
		if(checked.length > 0) {
			if(this.value === '') {
				indeferirBtn.prop('disabled', true);
				deferirBtn.prop('disabled', false);
			}
			else {
				indeferirBtn.prop('disabled', false);
				deferirBtn.prop('disabled', true);
			}
			
		}
		else {
			indeferirBtn.prop('disabled', true);
			deferirBtn.prop('disabled', true);
		}


		//indeferirBtn.prop('disabled', false);
		explicarMotivoIndeferir(this);
		
	});

	$('#procurar-por').on('keyup', function() {
		var key = $(this).val().toLowerCase();
		filtrarTabela(key);
	});

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

	function filtrarTabela(key) {
		$('#requerimentos tr:not(#head)').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(key) > -1)
		});
	}
});
</script>
@endsection

