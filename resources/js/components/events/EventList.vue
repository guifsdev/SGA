<template>
	<div class="container">
		<table class="table table-sm">
			<thead>
			<tr>
			  <th scope="col">Nome</th>
			  <th scope="col">Local</th>
			  <th scope="col">Data</th>
			  <th scope="col">Tipo</th>
			  <th scope="col">Duração</th>
			  <th scope="col">Carga horária</th>
			  <th scope="col">Organizador</th>
			</tr>
			</thead>
			<tbody>

				<tr v-for="event in events">
					<th scope="row">
						<a :href="'/admin/evento/' + event.id + '/editar'">{{event.nome}}</a>
					</th>
					<td>{{event.local}}</td>
					<td>{{event.data}}</td>
					<td>{{event.tipo}}</td>
					<td>{{event.duracao}}</td>
					<td>{{event.carga_horaria}}</td>
					<td>{{event.organizador}}</td>
				</tr>

			</tbody>
		</table>

		<a class="btn btn-primary" href="/admin/eventos/criar" role="button">Criar</a>
	</div>
</template>

<script>
	export default {
		props: ['eventsProp'],
		data: function() {
			return {
				events: null,
			}
		},
		mounted: function() {
			this.events = this.eventsProp;
		}

	}
</script>