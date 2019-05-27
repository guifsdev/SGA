@extends('layouts.master')

@section('title', 'SGA - Painel de Gerenciamento')

@section('nav_title', 'Usuários')

@include('partials.menu')

@section('content')
<div class="container" style="width: 500px; margin-top: 20px">
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">Nome</th>
	      <th scope="col">Email</th>
	      <th scope="col">CPF</th>
	      <th scope="col">Administrador</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($users as $user)
		<tr>
		  <th scope="row">{{$user['name']}}</th>
		  <td>{{$user['email']}}</td>
		  <td>{{$user['cpf']}}</td>
		  <td>{{$user['is_admin'] ? 'Sim' : 'Não'}}</td>
		</tr>
		@endforeach
	  </tbody>
	</table>
	<a class="btn btn-primary" href="/admin/usuarios/criar" role="button">Criar</a>
</div>
@endsection