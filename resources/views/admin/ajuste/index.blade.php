@extends('layouts.master')

@section('nav_title', 'Requerimentos de Ajuste')

@section('content')

@section('custom_styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="{{asset('css/custom_checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/custom_datepicker.css')}}">
@endsection

@include('partials.menu')

<div class="container-fluid">
	<div class="admin-ajuste">
		<div class="container-fluid">
			<h4>Filtros <a class="btn btn-light collapse_btn" data-collapse="#filters"><i class="fa fa-plus-square-o"></i></a></h4>
				<div id="filters">
					<form id="main_filter">
						{{csrf_field()}}
						<!-- #filter type -->
						<div class="grupo-filtro">
							<label class="fixed-width-labels" for="result-check">Tipo de filtro:</label>
							<select class="custom-select custom-select-sm filter_input" name="filter_type">
								<option value="and">E</option>
								<option value="or">OU</option>
							</select>
						</div>



						<div class="grupo-filtro">
							<input id="name-check" type="checkbox"/><label class="fixed-width-labels" for="name-check">Nome:</label>
							<input type="text" class="form-control filter_input" name="student_name" 
								value="">
						</div>
						
						<div class="grupo-filtro">
							<input id="cpf-check" type="checkbox"/><label class="fixed-width-labels" for="cpf-check">CPF:</label>
							<input type="text" class="form-control filter_input" name="student_cpf"
								value="">	
						</div>
						
						<div class="grupo-filtro">
							<input id="matricula-check" type="checkbox"/><label class="fixed-width-labels" for="matricula-check">Matricula:</label>
							<input type="text" class="form-control filter_input" name="student_matricula"
								value="">
						</div>
						<div class="grupo-filtro">
							<input id="period-check" type="checkbox"/><label class="fixed-width-labels" for="period-check">Periodo:</label>
							<select class="custom-select custom-select-sm filter_input" name="subject_period">
								<option value="">Selecione</option>
								<option value="all">Todos</option>
								@for($i = 1; $i <= 8; ++$i)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
						<div class="grupo-filtro">
							<input id="subject-check" type="checkbox"/><label class="fixed-width-labels" for="subject-check">Disciplina:</label>
							<select class="custom-select custom-select-sm filter_input" name="subject_id">
								<option value="">Selecione</option>
								<option value="all">Todas</option>
								@foreach($subjects as $subject)
								<option value="{{$subject->id}}">{{$subject->code . ' ' . $subject->name}}</option>
								@endforeach
							</select>
						</div>
						
						<div class="grupo-filtro">
							<input id="requirement-check" type="checkbox"/><label class="fixed-width-labels" for="requirement-check">Requerimento:</label>
							<select class="custom-select custom-select-sm filter_input" name="action">
								<option value="all">Todos</option>
								<option value="incluir">Incluir</option>
								<option value="excluir">Excluir</option>
							</select>
						</div>
						<div class="grupo-filtro">
							<input id="result-check" type="checkbox"/><label class="fixed-width-labels" for="result-check">Resultado:</label>
							<select class="custom-select custom-select-sm filter_input" name="result">
								<option value="Pendente">Pendente</option>
								<option value="Deferido">Deferido</option>
								<option value="Indeferido">Indeferido</option>
								<option value="all">Todos</option>
							</select>
						</div>
						<div class="grupo-filtro">
							<input id="date_from_check" type="checkbox"/><label class="fixed-width-labels" for="date_from_check">Data de:</label>
							<input type="date" name="created_at_start" class="data-requerimento filter_input">
						</div>
						<div class="grupo-filtro">
							<input id="date_to_check" type="checkbox"/><label class="fixed-width-labels" for="date_to_check">Data até:</label>
							<input type="date" name="created_at_end" class="data-requerimento filter_input">
						</div>
						<button id="apply_filter" class="btn btn-primary">Aplicar</button>
						<button id="clear_filter" class="btn btn-secondary">Limpar</button>
					</form> <!-- #main_filter -->
					<hr>
					<div id="filtro-rapido" class="container-fluid">
						<h5>Filtrar linhas <a class="btn btn-light collapse_btn" data-collapse="#table_filter"><i class="fa fa-minus-square-o"></i></a></h5> 
						<div class="collapse-filtro-rapido" id="table_filter">
							<div class="grupo-filtro">
								<label class="fixed-width-labels" for="nome-check">Procurar por:</label>
								<input type="text" class="form-control filter_input" id="filter_table"
									placeholder="Nome, matricula, CPF, etc">
							</div>
						</div>
					</div>	<!-- #filtro-rapido -->	
				</div>
		</div>
		<hr>
		<form method="POST">
		{{csrf_field()}}
			<div
				class="container-fluid">
				<h4>Ações <a class="btn btn-light collapse_btn" data-collapse="#actions"><i class="fa fa-minus-square-o"></i></a></h4>
				
				<div id="actions">
					<div>
						<label class="fixed-width-labels" for="disciplina-check">Motivo indeferir:</label>
						<select name="motivo-indeferir" class="custom-select custom-select-sm filter_input" id="reason_deny">
							<option value=""></option>
							<option value="vaga">Não há vagas</option>
							<option value="pre-requisito">Não possui pré-requisito</option>
							<option value="horario-conflito">Horário em conflito</option>
							<option value="outro">Outro</option>
						</select>
		
						<div id="reason_description" class="collapse">
							<label class="fixed-width-labels" for="acoes-motivo">Descrição:</label>
			   				<textarea name="description" class="form-control" id="acoes-motivo" rows="3"></textarea>
						</div>
					</div>
		
					<div id="acoes-btns">
						<button type="button" class="btn btn-success adjust_update" id="defer" disabled>Deferir selecionados</button>
						<button type="button" class="btn btn-danger adjust_update" id="deny" disabled>Indeferir selecionados</button>
					</div>
				</div>
			</div> <!-- #acoes -->
			<div id="adjustments" class="container-fluid">
				<table class="table table-sm">
					<thead>
					<tr id="head">
						  <th><input id="check_many" type="checkbox"/><label for="check_many"></label></th>
						  <th scope="col">Nº</th>
						  <th scope="col">Nome</th>
						  <th scope="col">CPF</th>
						  <th scope="col">Matricula</th>
						  <th scope="col">Código / Disciplina</th>
						  <!-- <th scope="col">Disciplina</th> -->
						  <th scope="col">Motivo indeferido</th>
						  <th scope="col">Requerimento</th>
						  <th scope="col">Data requerimento</th>
						  <th scope="col">Resultado</th>
						</tr>
					</thead>
					<tbody>
						@foreach($adjustments as $adjustment)
						<tr>
							<th scope="row">
								<input id="{{$adjustment->id}}" class="adjust_check" type="checkbox"/><label for="{{$adjustment->id}}"></label>
							</th>	
							<td>{{$adjustment->id}}</td>
							<td>{{$adjustment->student->nome}}</td>	
							<td>{{$adjustment->student->cpf}}</td>	
							<td>{{$adjustment->student->matricula}}</td>	
							<td>{{$adjustment->subject->code . ' ' . $adjustment->subject->name}}</td>	
							<td id="reason_denied">{{$adjustment->reason_denied}}</td>	
							<td>{{$adjustment->action}}</td>	
							<td>{{$adjustment->created_at}}</td>	
							<td id="result">{{$adjustment->result}}</td>
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
<script type="text/javascript" src="{{ asset('/js/admin_ajuste.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.mask.min.js') }}"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('input[name="cpf"]').mask('000.000.000-00');
	$('.adjust_update').on('click', function(evt) {
		updateAdjustments(evt.target.id);
	});
	$('#reason_deny').on('change', function() {
		let checks = ($('.adjust_check:checked').length > 0);
		let state = ($(this).val() != '');

		if(checks) {
			toggleDenyChecked(state); 
			if($(this).val() == 'outro') toggleDescription(true);
			else toggleDescription(false);
		}
		else toggleDenyChecked(false);
	});
	$('#adjustments').on('change', '.adjust_check', function() {
		let checks = ($('.adjust_check:checked').length > 0);
		$(this).prop('checked', function(i, value) {
			if(checks) {
				toggleDeferChecked(true);
				if($('#reason_deny').val() != '') 
					toggleDeferChecked(true);
			}
			else {
				toggleDeferChecked(false);
				toggleDenyChecked(false);
				toggleDescription(false);
			}
		});
	});
	$('.collapse_btn').on('click', function() {
		let target = $(this).data('collapse');
		$(target).toggleClass('collapse');
	});

	$('#adjustments').on('click', '#check_many', checkMany);

	$('#main_filter .filter_input').on('focusout', function() {
		let checkbox = $(this).siblings('[type="checkbox"]');
		checkbox.prop('checked', $(this).val() != '' ? true : false);
	});

	$('#apply_filter').on('click', function(e) {
		e.preventDefault();
		$('input[name="cpf"]').unmask();
		sendFilterParams();
	});

	$('#clear_filter').on('click', function(e) {
		e.preventDefault();
		clearFilter();
	});

	$('#filter_table').on('keyup', function() {
		let key = $(this).val().toLowerCase();
		filterTable(key);
	});
});
</script>
@endsection

