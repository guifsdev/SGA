<template>
	<div class="container">
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input 
				v-model="$parent.student.nome"
				type="text" class="form-control" id="nome" name="nome" 
				disabled>
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" 
				disabled="disabled"
				v-model="$parent.student.cpf">
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
				name="matricula" disabled="disabled"
				v-model="$parent.student.matricula">
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" 
				disabled="disabled"
				v-model="$parent.student.email" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" 
				disabled="disabled"
				v-model="$parent.student.tel" >
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
				<tr v-for="adjustment in $parent.adjustments">
				  <td scope="row">
				  	{{adjustment['period']}}
				  </td>
				  <td>
				  	{{adjustment['subject_name']}}
				  </td>
				  <td style="width: 5%" class="align-radio-center">
				  	{{adjustment['action'] == '1' ? 'Incluir' : 'Excluir'}}
				  </td>
				</tr>
		  </tbody>
		</table>
		<!-- Mensagem de sucesso -->
		<div class="alert alert-success" role="alert" v-if="$parent.success">
			{{$parent.success.message}}<br>
			<p>
				<span class="font-weight-bold">Autenticação: </span>{{$parent.success.stamp.signature}}<br>
				<span class="font-weight-bold">Data do requerimento: </span>{{$parent.success.stamp.date}}
			</p>
		</div>
		
		<!-- Encerrar -->
		<div class="form-group align-center">
			<button 
				@click="$emit('home')"
				class="btn btn-primary" type="button">
			  	Finalizar
			</button>

		</div>
	</div>
</template>

<script>
	export default {}
</script>