<template>
	<div v-if="event" class="container">
		<div class="card">
		  <h5 class="card-header">{{event.nome}}</h5>
		  <div class="card-body">
			<span class="font-weight-bold">Data:</span> {{event.data}} <br>
			<span class="font-weight-bold">Local:</span> {{event.local}} <br>
			<span class="font-weight-bold">Tipo:</span> {{event.tipo}} <br>
			<span class="font-weight-bold">Duração:</span> {{event.duracao}} horas <br>
			<span class="font-weight-bold">Carga </span>horária: {{event.carga_horaria}} <br>
			<span class="font-weight-bold">Organizador:</span> {{event.organizador}} <br>
			<span class="font-weight-bold">Template:</span> {{event.template}} <br>
			<span class="font-weight-bold">Participantes:</span>
			<hr>
		    <h5 class="card-title">Descrição</h5>
		    <p class="card-text">{{event.descricao}}</p>
		    <a :href="'/admin/evento/' + event.id + '/editar'" class="btn btn-primary">Editar evento</a>
		  </div>
		</div>
	</div>
</template>

<script>
export default {
	props: ['eventProp'],
	data: function() {
		return {
			event: null,
		}
	},
	mounted: function() {
		this.event = this.eventProp;
	}
}	
</script>