<div class="container" style="max-width: 100%; margin: 0; padding: 0">

	<form method="POST" action="">
	{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input disabled="disabled" type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" value="{{request('nome')}}" >
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input disabled="disabled" type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" value="{{request('cpf')}}" >
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input disabled="disabled" type="text" class="form-control" id="matricula" placeholder="Sua matrícula" value="{{request('matricula')}}" name="matricula" >
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input disabled="disabled" type="email" class="form-control" id="email" name="email" value="{{request('email')}}" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input disabled="disabled" type="tel" class="form-control" id="telefone" name="tel" value="{{request('tel')}}" >
		</div>
			<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col" style="width: 20%">Período</th>
			      <th scope="col">Disciplina</th>
			      <th scope="col">Requerimento</th>
			    </tr>
			  </thead>
			  <tbody>
				@for($i = 1; $i <= count(request('periodo-ajuste')); ++$i)
					<tr class="ajuste" id="{{$i}}">
					  <td scope="row">
					  	<input name="periodo-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('periodo-ajuste')[$i]}}">
					  </td>
					  <td>
					  	<input name="disciplina-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('disciplina-ajuste')[$i]}}">
					  </td>
					  <td style="width: 5%" class="align-radio-center">
					  	<input name="acao-ajuste[{{$i}}]" class="form-control" type="text" disabled="disabled" value="{{request('acao-ajuste')[$i]}}">
					  </td>
					  <td style="width: 5%" class="align-radio-center">
					  </td>
					</tr>
				@endfor
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button type="submit" class="btn btn-primary" aria-describedby="aviso" id="salvar">Confirmar</button>
				<button type="submit" class="btn btn-secondary" aria-describedby="aviso" id="modificar">Modificar</button>
			</div>	
	</form>
	@include('partials.errors')
</div>

<script>
$(document).ready(function() {
	$('button:submit').on('click', function(e) {
		e.preventDefault();
		reenableInputs();
		
		if($(this).attr('id') == 'salvar') {
		    $(this).attr('disabled', true);
		}
		var form = $('form');
		var action = '/ajuste/' + $(this).attr('id');

		ajusteAction(form, action);
	});
});
</script>

