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
	background-image: url({{$template_url}});
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
	margin-top: 15%;
	font-size: 1.2em;
	text-align: center;
}
#qr-code {
	position: fixed;
	right: 150px;
	bottom: 150px;

}


</style>

<div class="container">
	<div id="template"></div>
	<div id="text">
		<p>Conferido a <span style="font-weight: bold;">{{$student->nome}}</span>, portador(a) do CPF de nº <span style="font-weight: bold;">{{$student->cpf}}</span>, pela participação no evento "{{$certificate->event->nome}}", realizado em {{$eventDay}} com carga horária de {{$certificate->event->carga_horaria}} horas.</p>
	</div>
	<div id="footer">
		<p>Niterói, {{$today}}, às {{$now}}<br>
		<span style="font-size: .8em">Este documento foi gerado pelo Sistema Acadêmico do SGA <br>
			Para verificar sua autenticidade, escaneie o qrcode ao lado ou visite <br> 
			<a href="http://aplicacoes.sga.uff.br/certificado/validar">http://aplicacoes.sga.uff.br/certificado/validar</a> e insira o código:<br>
		<pre>{{$hash}}</pre>
		</span>
		</p>
		<img id="qr-code" src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(140)->generate($validation_url)) }} ">
	</div>
</div>




@endsection