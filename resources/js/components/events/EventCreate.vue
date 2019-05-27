<template>
	<div class="container">
	<form 
		@submit.prevent="onSubmit"
		method="POST" 
		action="/admin/eventos/criar">
		<div class="form-group">
			<label for="nome">Nome:</label>
			<input 
				v-model="event.nome"
				type="text" class="form-control" id="nome" name="nome" placeholder="Nome do evento">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição:</label>
    		<textarea 
    			v-model="event.descricao"
    			class="form-control" name="descricao" id="descricao" rows="3"></textarea>
		</div>
		<div class="form-group">
			<label for="local">Local:</label>
			<input 
				v-model="event.local"
				type="text" class="form-control" id="local" name="local" placeholder="Local do evento">
		</div>
		<div class="form-group">
			<label for="data">Data:</label>
			<input 
				v-model="event.data"
				type="datetime-local" class="form-control" id="data" name="data" placeholder="Data do evento">
		</div>
		<div class="form-group">
			<label for="tipo">Tipo (atividade complementar):</label>
			<input 
				v-model="event.tipo"
				type="text" class="form-control" id="tipo" name="tipo" placeholder="1, 2 ou 3">
		</div>
		<div class="form-group">
			<label for="duracao">Duração (em horas):</label>
			<input 
				v-model="event.duracao"
				type="number" class="form-control" min="1" step="1" id="duracao" name="duracao" placeholder="Duração do evento">
		</div>
		<div class="form-group">
			<label for="carga-horaria">Carga horária:</label>
			<input 
				v-model="event.carga_horaria"
				type="number" class="form-control" min="1" step="1" id="carga-horaria" name="carga_horaria" placeholder="Carga horária do evento">
		</div>
		<div class="form-group">
			<label for="organizador">Organizador:</label>
			<input
				v-model="event.organizador"
				type="text" class="form-control" id="organizador" name="organizador" placeholder="Organizador do evento">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Salvar</button>
		</div>

		<div
			v-if="success" 
			class="alert alert-success" role="alert">
		  	{{success.message}}
		</div>
	</form>
</div>
</template>

<script>
	export default {
		data: function() {
			return {
				success: '',
				event: {
					nome: '',
					descricao: '',
					local: '',
					data: '',
					tipo: '',
					duracao: '',
					carga_horaria: '',
					organizador: '',
				}
			}
		},
		methods: {
			onSubmit: function() {
				axios.post('/admin/evento/criar', this.event)
					.then(response => {
						//console.log(response);
						this.success = response.data
					});
			} 
		}
	}
</script>