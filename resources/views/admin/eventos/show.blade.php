@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Evento')

@include('partials.menu')

@section('content')

<div class="container">
	<h3>{{$event['nome']}}</h3>
	<p>
		Data: {{$event['data']}} <br>
		Local: {{$event['local']}}
	</p>
	<p>
		Tipo: {{$event['tipo']}} <br>
		Duração: {{$event['duracao']}} horas <br>
		Carga horária: {{$event['carga_horaria']}} <br>
		Organizador: {{$event['organizador']}} <br>
		Template: {{$event['template']}} <br>
		Participantes: 
	</p>
	<h5>Descrição</h5>
	<p>
		{{$event['descricao']}}
	</p>
	<a class="btn btn-primary" href="/admin/eventos/{{$event['id']}}/editar" role="button">Editar</a>
</div>




@endsection