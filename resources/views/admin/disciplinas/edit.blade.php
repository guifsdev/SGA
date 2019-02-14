@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Editar disciplina')


@section('content')

@include('admin.menu')



<div class="container" style="width: 600px; margin-top: 50px">
	<h4>{{$subject->name}}</h4>
	<form action="/admin/disciplinas/{{$subject->id}}/{{$division->id}}/editar">
		<div class="form-group">
		    <label for="code">Código</label>
		    <input type="text" class="form-control" id="code" name="code" value="{{$subject->code}}">
		</div>
		<div class="form-group">
		    <label for="name">Nome</label>
		    <input type="text" class="form-control" id="name" name="name" value="{{$subject->name}}">
		</div>
		<div class="form-group">
		    <label for="period">Período</label>
		    <input type="number" min="1" max="8" class="form-control" id="period" name="period" value="{{$subject->period}}">
		</div>
		<div class="form-group">
		    <label for="division">Turma</label>
		    <input type="text" class="form-control" id="division" name="division" value="{{$division->name}}">
		</div>
		<div class="form-group">
		    <label for="code">Ofertada</label>
			<select name="offered" class="custom-select custom-select-sm" id="offered">
				<option value="1" {{$division->offered ? 'selected' : ''}}>Sim</option>
				<option value="0" {{!$division->offered ? 'selected' : ''}}>Não</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Salvar</button>
		<a class="btn btn-primary" href="{{url()->previous()}}" role="button">Cancelar</a>
	</form>
</div>








@endsection