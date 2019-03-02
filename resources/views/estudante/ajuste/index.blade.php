<div class="container" style="max-width: 100%; margin: 0; padding: 0"><!-- <h3>Ajuste de disciplinas do aluno</h3> -->
	
	<form method="POST" action="/ajuste/confirmar" id="ajuste-form">
	{{csrf_field()}}
		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="cpf" placeholder="CPF" name="cpf" disabled="disabled" value="{{$cpf}}">
		</div>
	
		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
				name="matricula" disabled="disabled"
				value="{{$matricula}}">
		</div>
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" 
				value="{{$nome_completo}}">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" 
				value="{{isset($request['email']) ? $request['email'] : ''}}">
		</div>
	
		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" 
				value="{{isset($request['tel']) ? $request['tel'] : ''}}">
		</div>
		<table class="table table-sm">
		  <thead>
		    <tr>
		      <th scope="col" style="width: 20%">Período</th>
		      <th scope="col">Disciplina</th>
		      <th scope="col">Incluir</th>
		      <th scope="col">Excluir</th>

		    </tr>
		  </thead>
		  <tbody>
		  	@for($i = 1; $i <= $config['max_ajustes']; ++$i)
				@include('estudante.ajuste.row')
			@endfor
		  </tbody>
		</table>
		<div class="form-group align-center">
			<button type="submit" class="btn btn-primary" id="confirmar" aria-describedby="aviso">Ajustar plano de estudos</button>
		</div>
		<small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
	@include('partials.errors')
	</form>
</div>
<script>
$(document).ready(function() {
	$('button:submit').on('click', function(e) {
		e.preventDefault();
		reenableInputs();
		var form = $('form');
		var action = '/ajuste/' + $(this).attr('id');

		ajusteAction(form, action);
	});

	$('.periodo').on('change', function() {
	    buscarDisciplinas('/ajuste', this);
	});
});
</script>