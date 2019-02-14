@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Disciplinas')


@section('content')

@include('admin.menu')


<div class="content">
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">Código</th>
	      <th scope="col">Nome</th>
	      <th scope="col">Periodo</th>
	      <th scope="col">Turma</th>
	      <th scope="col">Ofertada</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($subjects as $subject)
			@foreach($subject->divisions as $division)
			<tr>
				<th scope="row">{{$subject->code}}</th>
				<td><a href="/admin/disciplinas/{{$subject->id}}/{{$division->id}}">{{$subject->name}}</a></td>
				<td>{{$subject->period}}</td>
				<td>{{$division->name}}</td>
				<td>{{$division->offered ? 'Sim' : 'Não'}}</td>
			</tr>
			@endforeach
		@endforeach
	  </tbody>
	</table>
</div>



@endsection