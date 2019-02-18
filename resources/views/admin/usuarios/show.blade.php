@extends('layouts.master')

@section('title', 'SGA - Painel de Gerenciamento de ajustes e certificados')

@section('nav_title', 'Usuários')

@include('partials.menu')

<div class="container" style="width: 500px">
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">Id</th>
	      <th scope="col">Nome</th>
	      <th scope="col">Email</th>
	      <th scope="col">Matricula</th>
	      <th scope="col">Cargo</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($users as $user)
		<tr>
		  <th scope="row">{{$user['id']}}</th>
		  <td>{{$user['name']}}</td>
		  <td>{{$user['email']}}</td>
		  <td>{{$user['matricula']}}</td>
		  <td>{{$user['role']}}</td>
		</tr>
		@endforeach
	  </tbody>
	</table>
	<a class="btn btn-primary" href="/admin/usuarios/criar" role="button">Criar</a>
</div>