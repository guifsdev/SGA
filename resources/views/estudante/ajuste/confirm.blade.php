<div class="container" style="max-width: 100%; margin: 0; padding: 0">

	<form id="student_data">
	{{csrf_field()}}
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input disabled="disabled" type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" value="{{$studentData['nome']}}" >
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input disabled="disabled" type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" value="{{$studentData['cpf']}}" >
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input disabled="disabled" type="text" class="form-control" id="matricula" placeholder="Sua matrícula" value="{{$studentData['matricula']}}" name="matricula" >
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input disabled="disabled" type="email" class="form-control" id="email" name="email" value="{{$studentData['email']}}" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input disabled="disabled" type="tel" class="form-control" id="telefone" name="tel" value="{{$studentData['tel']}}" >
		</div>

	</form>

	<form>
		<table class="table table-sm">
		  <thead>
		    <tr>
		      <th scope="col" style="width: 20%">Período</th>
		      <th scope="col">Disciplina</th>
		      <th scope="col">Requerimento</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($adjustments as $adjustment)
				<tr>
				  <td scope="row">
				  	<input class="form-control period" type="text" disabled="disabled" value="{{$adjustment['period']}}">
				  </td>
				  <td>
				  	<input class="form-control subject_name" type="text" disabled="disabled" 
				  		value="{{$adjustment['subject_name'] . ' ' . $adjustment['class_name']}}">
				  </td>
				  <td style="width: 5%" class="align-radio-center">
				  	<input class="form-control" type="text" disabled="disabled" 
				  		value="{{$adjustment['action'] == '0' ? 'Excluir' : 'Incluir'}}">

			  		<input type="hidden" class="action" value="{{$adjustment['action']}}">
			  		<input type="hidden" class="subject_id" value="{{$adjustment['subject']['id']}}">
				  </td>
				  <td style="width: 5%" class="align-radio-center">
				  </td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		<div class="form-group align-center">
			<!-- <button type="submit" class="btn btn-primary" aria-describedby="aviso" id="salvar">Confirmar</button> -->
			<!-- <button type="submit" id="salvar" class="btn btn-primary" 
				data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Salvando">Confirmar</button> -->

			<button id="save" type="submit" class="btn btn-primary" type="button">
			  Confirmar
			</button>
			<button id="modify" class="btn btn-secondary" aria-describedby="aviso" >Modificar</button>
		</div>	
	</form>
	@include('partials.errors')
</div>

<script>
$(document).ready(function() {
	$('#modify').on('click', function(e) {
		e.preventDefault();
		adjustModify();
	});

	$('#save').on('click', function(e) {
		e.preventDefault();
		adjustSave();
	})


	/*$('button:submit').on('click', function(e) {
		e.preventDefault();
		reenableInputs();

		var $this = $(this);
		if($this.attr('id') == 'salvar') {
			$this.attr('disabled', true);
			$this.html('Salvando... ');
			$this.append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		}
		var form = $('form');
		var action = '/ajuste/' + $(this).attr('id');

		ajusteAction(form, action);
	});*/
});
</script>

