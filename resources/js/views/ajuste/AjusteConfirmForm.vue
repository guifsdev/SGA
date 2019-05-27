<template>
	<div class="container" v-if="$parent.student">
		<form id="student_data" @submit.prevent="onSubmitAdjustments">
			<div class="form-group">
				<label for="cpf">CPF:</label>
				<input 
					:value="$parent.student.cpf" 
					name="cpf"
					readonly 
					type="text" class="form-control" id="cpf" placeholder="CPF">
			</div>
		
			<div class="form-group">
				<label for="matricula">Matrícula:</label>
				<input 
					:value="$parent.student.matricula" 
					name="matricula"
					readonly 
					type="text" class="form-control" id="matricula" placeholder="Sua matrícula">
			</div>
			<div class="form-group">
				<label for="nome">Nome completo:</label>
				<input 
					:value="$parent.student.nome" 
					name="nome"
					readonly 
					type="text" class="form-control" id="nome" placeholder="Seu nome">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input 
					:value="$parent.student.email" 
					name="email"
					readonly 
					type="email" class="form-control" id="email">
			</div>
		
			<div class="form-group">
				<label for="telefone">Telefone:</label>
				<input 
					:value="$parent.student.tel"
					name="tel"
					type="tel" class="form-control" id="telefone"
					readonly>
			</div>

			<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col" style="text-align: center; width: 15%">Período</th>
			      <th scope="col" style="text-align: center">Disciplina</th>
			      <th scope="col" style="text-align: center; width: 15%">Ação</th>

			    </tr>
			  </thead>
			  <tbody>
				<tr v-for="adjustment in $parent.adjustments">
					<td style="text-align: center;">{{adjustment.period}}</td>
					<td>{{adjustment.subject_name}}</td>
					<td style="text-align: center;">{{actionText(adjustment.action)}}</td>
				</tr>
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button
					:disabled="loading"
					class="btn btn-primary" 
					aria-describedby="aviso">
					<span v-if="loading" 
						class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  					{{loading ? 'Processando...' : 'Enviar'}}
				</button>
				<button
					@click.prevent="$emit('modify')"
					class="btn btn-primary"
					:disabled="loading"
					aria-describedby="aviso">Alterar</button>
			</div>
		</form>

		<div
			v-if="errors.length"
			class="alert alert-danger" role="alert">
		  	<ul>
		  		<li v-for="error in errors">{{error}}</li>
		  	</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {
				errors: [],
				loading: false,
			}
		},
		methods: {
			actionText: function(action) {
				if(action == 0) return 'Excluir';
				else if(action == 1) return 'Incluir';
			},
			onSubmitAdjustments: function() {
				this.loading = true;
				axios.post('/ajuste/store', {

					student: this.$parent.student,
					adjustments: this.$parent.adjustments,

				}).then(response => {
					if(response.data.success) {
						this.$emit('success', response.data);
					}
				});
			}
		},
		mounted: function() {
		}
	}
</script>