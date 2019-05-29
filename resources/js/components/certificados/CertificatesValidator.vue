<template>
<div class="container" style="margin-top: 27px">
	<form @submit.prevent="onSubmit">
		<h4>Valide um documento emitido pelo SGA</h4>
		<div class="form-group">
			<label for="hash">String de validação:</label>
			<input 
				v-model="hash"
				type="text" class="form-control" id="hash" required>
			
		</div>
		<button type="submit" class="btn btn-primary">Validar</button>
	</form>
	<div v-if="valid" class="alert alert-success" role="alert">
	  O documento é válido. <br>
	  <span class="font-weight-bold">Data de emissão: </span>{{this.created_at}} <br>
	  <span class="font-weight-bold">CPF: </span>{{this.cpf}}
	</div>
	<div v-if="valid === false " class="alert alert-danger" role="alert">
	  O documento não é válido.
	</div>
</div>	
</template>

<script>
export default {
	props: ['resultProp'],
	data: function() {
		return {
			result: null,
			created_at: '',
			cpf: '',
			valid: '',
			hash: '',
		}
	},
	methods: {
		onSubmit: function() {
			this.validate('string', this.hash);
		},
		getData: function(data) {
			Object.keys(data).forEach(entry => {
				this[entry] = data[entry];
				this.valid = true;
			})
		},
		validate: function(source = 'string', hash) {
			axios.get('/certificado/validar?&hash=' + this.hash + '&source=' + source)
				.then(response => {
					console.log(response.data);
					if(response.data.validation.length) {
						this.getData(response.data.validation[0]);
					}
					else this.valid = false;

				});
		}
	},
	mounted: function() {
		console.log(this.resultProp);
		this.result = this.resultProp;
		console.log(this.result);

		if(this.result.validation.length) {
			this.getData(this.result.validation[0]);
		} else if(this.result.hash) {
			this.hash = this.result.hash;
			this.valid = false;
		}
	}
}
</script>

<style>
	.alert {
		margin-top: 20px;
	}
</style>