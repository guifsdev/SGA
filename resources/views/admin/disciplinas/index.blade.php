@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Disciplinas')


@section('content')

@include('partials.menu')

<div class="container">
	@if(session()->has('success'))
		<div class="alert alert-success" role="alert">
	  		{{session('success')}}
		</div>
	@endif
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
				<td>{{$division->division_name}}</td>
				<td>{{$division->offered ? 'Sim' : 'Não'}}</td>
			</tr>
			@endforeach
		@endforeach
	  </tbody>
	</table>
</div>



@endsection