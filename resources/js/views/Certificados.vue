<template>
	<div class="container">
		<div 
			v-if="loading"
			class="d-flex justify-content-center">
		  	<div class="spinner-border" role="status">
		    	<span class="sr-only">Loading...</span>
		  	</div>
		</div>
		<table 
			v-else-if="certificates.length"
			class="table table-sm">
			<thead>
			<tr>
			  <th scope="col">Evento</th>
			  <th scope="col">Tipo</th>
			  <th scope="col">Carga horária</th>
			  <th scope="col">Organizador</th>
			  <th scope="col">Data</th>
			  <th scope="col" style="text-align: center">Certificado</th>
			</tr>
			</thead>
			<tbody>
				<tr v-for="certificate in certificates">
					<td scope="row">{{certificate.event.nome}}</td>
					<td>{{certificate.event.tipo}}</td>
					<td>{{certificate.event.carga_horaria}}</td>
					<td>{{certificate.event.organizador}}</td>
					<td>{{certificate.event.data}}</td>
					<td style="text-align: center;">
						<a 
							:href="'/estudante/certificado/' + certificate.id" 
							class="certificate" 
						   	target="_blank">
							<i class="fa fa-file-pdf"></i>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<div 
			v-else
			class="alert alert-primary" role="alert">
		  	A simple primary alert—check it out!
		</div>

	</div>
</template>

<script>
	export default {
		props: ['studentProps'],
		data: function() {
			return {
				student: null,
				certificates: [],
				loading: true,
			}
		},
		mounted: function() {
			this.student = this.studentProps;
			axios.post('/estudante/certificados', {cpf: this.student.cpf})
				.then(response => {
					this.loading = false;
					this.certificates = response.data.certificates;
				});
		}
	}
</script>

<style>
	.certificate {
		font-size: 20px;
	}
</style>