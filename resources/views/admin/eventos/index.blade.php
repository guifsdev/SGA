@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Gerenciamento de Eventos')


@section('content')

@include('partials.menu')

<div class="container" style="width: 100%">
	<table class="table table-sm" style="margin-top: 50px">
		<thead>
		<tr>
		  <th scope="col"">Nome</th>
		  <th scope="col">Local</th>
		  <th scope="col">Data</th>
		  <th scope="col">Tipo</th>
		  <th scope="col">Duração</th>
		  <th scope="col">Carga horária</th>
		  <th scope="col">Organizador</th>
		  <th scope="col">Template</th>
		</tr>
		</thead>
		<tbody>

			@foreach($events as $event)
			<tr>
				<th scope="row"><a href="/admin/eventos/{{$event['id']}}">{{$event['nome']}}</a></th>
				<td>{{$event['local']}}</td>
				<td>{{$event['data']}}</td>
				<td>{{$event['tipo']}}</td>
				<td>{{$event['duracao']}}</td>
				<td>{{$event['carga_horaria']}}</td>
				<td>{{$event['organizador']}}</td>
				<td>{{$event['template']}}</td>
			</tr>
			@endforeach

		</tbody>
	</table>

	@if(session()->has('success'))
		<div class="alert alert-success" role="alert">
		  {{session('success')}}
		</div>
	@endif

	<a class="btn btn-primary" href="/admin/eventos/criar" role="button">Criar</a>
</div>




@endsection