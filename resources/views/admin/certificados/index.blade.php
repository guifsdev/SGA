@extends('layouts.master')
@section('title', 'SGA - Gerenciamento de Certificados')
@section('nav_title', 'Certificados')


@section('content')
@include('partials.menu')

<div class="container">
	<table class="table table-sm" style="margin-top: 50px">
		<thead>
		<tr>
		  <th scope="col">Evento</th>
		  <th scope="col">Nome aluno</th>
		  <th scope="col">CPF</th>
		  <th scope="col">Email</th>
		  <th scope="col">Matrícula</th>
		  <th scope="col">Data</th>
		  <th scope="col">Carga horária</th>
		</tr>
		</thead>
		<tbody>

			@foreach($certificates as $certificate)
			<tr>
				<th scope="row"><a href="/admin/eventos/{{$certificate->event->id}}">{{$certificate->event->nome}}</a></th>
				<td>{{$certificate->student->nome}}</td>
				<td>{{$certificate->student->cpf}}</td>
				<td>{{$certificate->student->email}}</td>
				<td>{{$certificate->student->matricula}}</td>
				<td>{{$certificate->event->data}}</td>
				<td>{{$certificate->event->organizador}}</td>
			</tr>
			@endforeach

		</tbody>
	</table>
</div>



@endsection