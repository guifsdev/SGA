<div class="container" style="max-width: 100%; margin: 0; padding: 0">

	<div class="form-group">
		<label for="nome">Nome completo:</label>
		<input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" 
			disabled="disabled"
			value="{{$student_data['nome']}}" >
	</div>

	<div class="form-group">
		<label for="cpf">CPF:</label>
		<input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" 
			disabled="disabled"
			value="{{$student_data['cpf']}}">
	</div>

	<div class="form-group">
		<label for="matricula">Matrícula:</label>
		<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
			name="matricula" disabled="disabled"
			value="{{$student_data['matricula']}}">
	</div>

	<div class="form-group">
		<label for="email">Email:</label>
		<input type="email" class="form-control" id="email" name="email" 
			disabled="disabled"
			value="{{$student_data['email']}}" >
	</div>

	<div class="form-group">
		<label for="telefone">Telefone:</label>
		<input type="tel" class="form-control" id="telefone" name="tel" 
			disabled="disabled"
			value="{{$student_data['tel']}}" >
	</div>
	<table class="table table-sm">
	  <thead>
	    <tr>
	      <th scope="col" style="width: 20%">Período</th>
	      <th scope="col">Disciplina</th>
	      <th scope="col">Ação</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($adjustments as $adjustment)
			<tr class="ajuste">
			  <td scope="row">
			  	{{$adjustment['subject']['period']}}
			  </td>
			  <td>
			  	{{$adjustment['subject']['name']}}
			  </td>
			  <td style="width: 5%" class="align-radio-center">
			  	{{$adjustment['action'] == '1' ? 'Incluir' : 'Excluir'}}
			  </td>
			</tr>
		@endforeach
	  </tbody>
	</table>
	<!-- Mensagem de sucesso -->
	<div class="alert alert-success" role="alert">
	  {{$success}}
	</div>
	<p>Autenticação: {{$validation['string']}}</p>
	<p>Data do requerimento: {{$validation['time']}}</p>
	
	<!-- Encerrar -->
	<div class="form-group align-center">
		<button class="btn btn-primary" type="button">
		  Finalizar
		</button>
	</div>
</div>

<script>
$(document).ready(function() {
	$('button').on('click', function() {
		loadDashboardView('/estudante/home');
	})
});
</script>