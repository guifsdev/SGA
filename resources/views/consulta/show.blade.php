@extends('layouts.master')

@section('content')

<h1>Consultando...</h1>
<div class="col-md-4 col-md-offset-4">
	<form method="post" action="/consulta">
		{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome" required>
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" name="matricula"  placeholder="Sua matrícula" required>
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" required>
		</div>
		<button type="submit" class="btn btn-primary" aria-describedby="aviso">Consultar requerimento</button>
		<small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
	</form>
</div>


@endsection