@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Criar Eventos')


@section('content')

@include('partials.menu')
<div class="container" style="width: 900px">
	<form method="POST" action="/admin/eventos/criar">
	{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome:</label>
			<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do evento">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição:</label>
    		<textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
		</div>
		<div class="form-group">
			<label for="local">Local:</label>
			<input type="text" class="form-control" id="local" name="local" placeholder="Local do evento">
		</div>
		<div class="form-group">
			<label for="data">Data:</label>
			<input type="datetime-local" class="form-control" id="data" name="data" placeholder="Data do evento">
		</div>
		<div class="form-group">
			<label for="tipo">Tipo (atividade complementar):</label>
			<input type="text" class="form-control" id="tipo" name="tipo" placeholder="1, 2 ou 3">
		</div>
		<div class="form-group">
			<label for="duracao">Duração (em horas):</label>
			<input type="number" class="form-control" min="1" step="1" id="duracao" name="duracao" placeholder="Duração do evento">
		</div>
		<div class="form-group">
			<label for="carga-horaria">Carga horária:</label>
			<input type="number" class="form-control" min="1" step="1" id="carga-horaria" name="carga_horaria" placeholder="Carga horária do evento">
		</div>
		<div class="form-group">
			<label for="organizador">Organizador:</label>
			<input type="text" class="form-control" id="organizador" name="organizador" placeholder="Organizador do evento">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Salvar</button>
		</div>

		@include('partials.errors')

	</form>
</div>
@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manage_events.js') }}"></script>
@endsection