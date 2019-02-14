@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Eventos')

@section('nav_title', 'Disciplinas')


@section('content')

@include('admin.menu')


<div class="container">

	<table class="table" style="width: 600px">
	  <thead>
	    <tr>
	      <th scope="col" colspan="2" style="text-align: center;">{{$subject->name}}</th>
	      <!-- <th scope="col"></th> -->
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <th scope="row">Código</th>
	      <td>{{$subject->code}}</td>
	    </tr>
	    <tr>
	      <th scope="row">Periodo</th>
	      <td>{{$subject->period}}</td>
	    </tr>
	    <tr>
	      <th scope="row">Turma</th>
	      <td>{{$division->name}}</td>
	    </tr>    
	    <tr>
	      <th scope="row">Ofertada</th>
	      <td>{{$division->offered ? 'Sim' : 'Não'}}</td>
	    </tr>
	  </tbody>
	</table>
	<a class="btn btn-primary" href="/admin/disciplinas/{{$subject->id}}/{{$division->id}}/editar" role="button">Editar</a>
	<a class="btn btn-primary" href="/admin/disciplinas" role="button">Voltar</a>



</div>



@endsection