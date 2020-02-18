<template>
	<div class="container" 
		v-if="$parent.student">
		<div class="container" style="margin-bottom: 2rem;"
			v-if="$parent.pending_adjustments.length">
			<h3>Requerimentos pendentes</h3>
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col">Disciplina</th>
						<th scope="col">Ação</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tr v-for="adjustment in $parent.pending_adjustments">
					<td>{{adjustment.subject_name}}</td>
					<td>{{adjustment.action}}</td>
					<td>{{adjustment.result}}</td>
				</tr>
			</table>
		</div>

		<form 
			@submit.prevent="onSubmitAdjustments">
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
					:disabled="loading || response.success"
					class="btn btn-primary" 
					aria-describedby="aviso">
					<span v-if="loading" 
						class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  					{{loading ? 'Processando...' : 'Enviar'}}
				</button>
				<button
					@click.prevent="$emit('modify')"
					class="btn btn-primary"
					:disabled="loading || response.success"
					aria-describedby="aviso">Alterar</button>
			</div>
		</form>
		<div v-if="response.success" class="alert alert-primary" role="alert">
			<p>{{response.message}}</p>
			<p>Assinatura: {{response.signature}}</p>
			
		</div>

		<div class="alert alert-danger" role="alert"
			v-if="errors.length">
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
				response: [],
			}
		},
		methods: {
			actionText: function(action) {
				if(action == 0) return 'Excluir';
				else if(action == 1) return 'Incluir';
			},
			onSubmitAdjustments: function() {
				this.loading = true;
				axios.post('/estudante/adjustment/store', {
					student: this.$parent.student,
					adjustments: this.$parent.adjustments,

				}).then(response => {
					if(response.data.success) {
						this.response = response.data;
						this.loading = false;
					}
				});
			}
		},
	}
</script>
