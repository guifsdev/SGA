<template>
	<div class="container" v-if="certificates">
		<table class="table table-sm">
			<thead>
			<tr>
			  <th scope="col">Evento</th>
			  <th scope="col">Nome aluno</th>
			  <th scope="col">CPF</th>
			  <th scope="col">Email</th>
			  <th scope="col">Matrícula</th>
			  <th scope="col">Data</th>
			  <th scope="col">Organizador</th>
			  <th scope="col">Carga horária</th>
			</tr>
			</thead>
			<tbody>

				<tr v-for="certificate in certificates">
					<th scope="row">
						<a :href="'/admin/evento/' + certificate.event.id">{{certificate.event.nome}}</a>
					</th>
					<td>{{certificate.student.nome}}</td>
					<td>{{certificate.student.cpf}}</td>
					<td>{{certificate.student.email}}</td>
					<td>{{certificate.student.matricula}}</td>
					<td>{{certificate.event.data}}</td>
					<td>{{certificate.event.organizador}}</td>
					<td>{{certificate.event.carga_horaria}}</td>
				</tr>

			</tbody>
		</table>
	</div>
</template>

<script>
	export default {
		props: ['certificatesProp'],
		data: function() {
			return {
				certificates: null, 
			}

		},
		mounted: function() { 
			this.certificates = this.certificatesProp;
		}

	}
</script>