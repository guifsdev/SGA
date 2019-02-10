@extends('layouts.certificado')

@section('title', 'SGA - Emitir Certificado')

@section('content')
@include($template)

<div class="container">
	<p>Evento: {{$event['nome']}}</p>
	<p>Template: {{$event['template']}}</p>
	<p>Descrição: {{$event['descricao']}}</p>
	<p>Particiante: {{$participant['nome']}}</p>
</div>



@endsection