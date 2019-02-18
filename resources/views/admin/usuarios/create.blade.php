@extends('layouts.master')

@section('title', 'SGA - Painel de Gerenciamento de ajustes e certificados')

@section('nav_title', 'Usuários - Criar')

@include('partials.menu')

<div class="container" style="width: 500px">
	<form method="POST" action="/admin/usuarios/criar">
	  {{csrf_field()}}
	  <div class="form-group">
	    <label for="nome">Nome</label>
	    <input type="text" class="form-control" id="nome" name="name" placeholder="Nome">
	  </div>
	  <div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
	  </div>
	  <div class="form-group">
	    <label for="cargo">Cargo</label>
		<select class="custom-select custom-select-sm" id="cargo" name="role">
		  <option value="servidor">Servidor</option>
		  <option value="admin">Administrador</option>
		</select>
	  </div>
	  <div class="form-group">
	    <label for="matricula">Matricula</label>
	    <input type="text" class="form-control" id="matricula" name="matricula">
	  </div>
	  <div class="form-group">
	    <label for="password">Senha</label>
	    <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
	  </div>
	  <button type="submit" class="btn btn-primary">Salvar</button>
	@include('partials.errors')
	</form>
</div>