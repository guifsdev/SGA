@extends('layouts.certificado')

@section('title', 'SGA - Emitir Certificado')

@section('content')

<style type="text/css">

@page {
	margin: 0;
}
#template {
	height: 100%;
	width: 100%;
	position: fixed;
	z-index: -1;
	background-image: url({{$url}});
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
}
#text {
	margin-top: 50%;
	font-size: 1.2em;
	margin-right: 96px;
	margin-left: 96px;
}
#footer {
	margin-top: 20%;
	font-size: 1.2em;
	text-align: center;
}


</style>

<div class="container">
	<div id="template"></div>
	<div id="text">
		<p>Conferido a <span style="font-weight: bold;">{{$student->nome}}</span>, pela participação no evento "{{$certificate->event->nome}}", realizado em {{$eventDay}} com carga horária de {{$certificate->event->carga_horaria}} horas.</p>
	</div>
	<div id="footer">
		<p>Niterói, {{$today}}, às {{$now}}<br>
		<span style="font-weight: bold;">CPF:</span> {{$student->cpf}}<br>
		<span style="font-size: .8em">Este documento foi gerado pelo Sistema Acadêmico do SGA <br>
			Para verificar sua autenticidade, visite: http://aplicacoes.sga.uff.br/certificado/validar <br>
		<pre>{{$hash}}</pre>
		</span>


		</p>

	</div>
</div>




@endsection