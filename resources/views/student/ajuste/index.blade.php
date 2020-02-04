<div class="container" style="max-width: 100%; margin: 0; padding: 0"><!-- <h3>Ajuste de disciplinas do aluno</h3> -->
	<form id="student_data">
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
				disabled="disabled" 
				value="{{$nome_completo}}">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" 
				value="{{isset($studentAttributes) ? $studentAttributes['email'] : $student->email}}">
		</div>
	
		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" 
				value="{{isset($studentAttributes) ? $studentAttributes['tel'] : $student->tel}}">
		</div>
	</form>

	<form id="adjustment">
		<table class="table table-sm">
		  <thead>
		    <tr>
		      <th scope="col" style="text-align: center; width: 15%">Período</th>
		      <th scope="col" style="text-align: center">Disciplina</th>
		      <th scope="col" style="text-align: center; width: 15%">Ação</th>

		    </tr>
		  </thead>
		  <tbody>
		  	@for($i = 1; $i <= $settings['max_ajustes']; ++$i)
				<tr>
				  <!-- period select -->
				  <td>
					<select class="custom-select custom-select-sm period" name="period[{{$i}}]">
					  	<option selected value="">Selecione</option>
						@for($j = 1; $j <= 8; ++$j)
							<option value="{{$j}}">{{$j}}</option>
						@endfor
					</select>
				  </td>
				  <!-- subject select -->
				  <td>
					<select class="custom-select custom-select-sm subject_id" id="subject" name="subject[{{$i}}]">
					  <option selected value="">Selecione</option>
					</select>
				  </td>
				  <!--  -->
				  <td class="align-radio-center">
				  	<select name="action[{{$i}}]" id="action" class="custom-select custom-select-sm action">
				  		<option value="">Selecione</option>
				  	</select>
				  </td>
				</tr>
			@endfor

		  </tbody>
		</table>
		<div class="form-group align-center">
			<button class="btn btn-primary" id="confirm" aria-describedby="aviso">Ajustar plano de estudos</button>
		</div>
		<small id="aviso" class="form-text text-muted">Preencha todos os campos do formulário – esta reponsabilidade é do requerente, os documentos incompletos não serão processados.</small>
	@include('partials.errors')
	</form>

</div>
<script>
$(document).ready(function() {
	$('#telefone').mask('(00) 00000-0000');

	$('.period').on('change', function() {
		let period = $(this).val(),
			row = $(this).closest('tr');
		getAdjustSubjects(period, row);		
	});

	$('#confirm').on('click', function(e) {
		e.preventDefault();
		adjustConfirm();
	});
});
</script>

