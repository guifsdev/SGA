@extends('layouts.master')

@section('title', 'SGA - Painel de Gerenciamento de ajustes e certificados')

@section('nav_title', 'Usuários - Criar')

@section('content')
@include('partials.menu')

<div class="container" style="width: 500px; margin-top: 20px">
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
	    <label for="cpf">CPF</label>
	    <input type="text" class="form-control" id="cpf" name="cpf">
	  </div>
	  <div class="form-group">
	    <label for="password">Senha</label>
	    <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
	  </div>
	  <div class="form-group">
	    <label for="cargo">Administrador</label>
		<select class="custom-select custom-select-sm" id="is_admin" name="is_admin">
		  <option value="1">Sim</option>
		  <option value="0">Não</option>
		</select>
	  </div>
	  <button type="submit" class="btn btn-primary">Salvar</button>
	@include('partials.errors')
	</form>
</div>
@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#cpf').mask('000.000.000-00', {reverse: true});

    $('form').on('submit', function() {
        removeMask($('#cpf'));
    })
});
</script>
@endsection
