@extends('layouts.certificado')

@section('title', 'SGA - Emitir Certificado')

@section('content')

<style type="text/css">

@page {
	margin: 0;
}
</style>

<div id="template">
	<div id="participante">
		<p>Evento: {{$event['nome']}}</p>
		<p>Template: {{$event['template']}}</p>
		<p>Descrição: {{$event['descricao']}}</p>
		<p>Particiante: {{$participant['nome']}}</p>
	</div>
</div>




@endsection