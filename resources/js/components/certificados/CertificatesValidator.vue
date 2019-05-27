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
	  O documento é válido.
	</div>
	<div v-if="valid === false " class="alert alert-danger" role="alert">
	  O documento não é válido.
	</div>
</div>	
</template>

<script>
export default {
	data: function() {
		return {
			valid: '',
			hash: '',
		}
	},
	methods: {
		onSubmit: function() {
			axios.get('/certificado/validar/' + this.hash)
				.then(response => {
					//console.log(response.data);
					if(response.data.validation.length) this.valid = true;
					else this.valid = false;
				})
		}
	}
}
</script>

<style>
	.alert {
		margin-top: 20px;
	}
</style>