<template>
	<div class="container" v-if="events">
		<form 
			@submit.prevent="onSubmit">
			<div class="form-group">
				<label for="metodo-inserir">Evento:</label>
				<select
					@change="onEventChange"
					v-model="eventId" 
					class="form-control" id="evento" name="evento"
					required>
					<option selected v-for="event in events" :value="event.id">{{event.nome}}</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="template">Template:</label>
				<select 
					v-model="template"
					required 
					class="form-control" id="template" name="template">
					<option 
						v-for="t in templates"
						:value="t">{{t}}</option>
				</select>
			</div>

			<div class="form-group" style="margin-bottom: 0">
				<label for="template">Emitir certificados:</label>
			</div>
			<div class="container form-group" id="emit-group">
				<table class="table order-list">
				    <thead>
				        <tr>
				            <th scope="col" style="width: 25%">CPF</th>
				            <th scope="col" style="width: 25%">Matrícula</th>
				            <th scope="col" style="width: 25%">Nome</th>
				            <th scope="col" style="width: 25%">Email</th>
				        </tr>
				    </thead>
				    <tbody>
				        <tr>
							<td>
								<input 
									type="text" 
									maxlength="11" 
									class="form-control" 
									v-model="cpf"
									name="cpf">
				            	<!-- <vue-mask 
			            	        class="form-control"
			            	        v-model="cpf" 
			            	        mask="000.000.000-00" 
			            	        required
			            	        :raw="false"> 
			            	    </vue-mask> -->
							</td>
							<td>
								<input 
									type="text" 
									class="form-control" 
									v-model="matricula"
									name="matricula">
							</td>
							<td>
								<input 
									type="text"
									required
									class="form-control" 
									v-model="attendant_name"
									name="attendant_name">
							</td>
							<td>
								<input 
									type="email" 
									class="form-control" 
									v-model="email"
									name="email">
							</td>
				        </tr>
				    </tbody>
				    <tfoot>
				        <tr>
				            <td colspan="1" style="text-align: left;">
				                <input 
				                	:disabled="emitDisabled"
				                	type="submit" class="btn btn-primary" id="emit" value="Emitir"
				                	style="width: 100%">
				            </td>
				            <td id="result" colspan="3" style="color: red"></td>
				        </tr>
				    </tfoot>
				<span
					v-if="found" 
					style="color: red">1 estudante loacalizado</span>
				</table>
			</div>
			<div class="form-group" style="margin-bottom: 0">
				<label for="template">Certificados emitidos:</label>
			</div>
	  	    <div
	  	    	v-if="success"
	  	    	:class="success.status ? 'alert-success': 'alert-danger'"
	  	    	class="alert alert-dismissible" role="alert">
	  	      	{{success.message}}
				<button 
					@click="success = ''"
					type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
	  	    </div>
			<div class="container form-group emited-group" id="certificates_table">
			  	<p style="display: none;">Nenhum certificado emitido.</p>
			  	<table class="table" id="emited" style="">
			  	    <thead>
			  	        <tr>
			  	            <th scope="col" style="width: 30%">Nome</th>
			  	            <th scope="col" style="width: 30%">Email</th>
			  	            <th scope="col" style="width: 20%">Matrícula</th>
			  	            <th scope="col" style="width: 20%">CPF</th>
			  	        </tr>
			  	    </thead>
			  	    <tbody>
			  	    	<tr v-for="certificate in certificates">
			  	    		<td>{{certificate.nome}}</td>
			  	    		<td>{{certificate.email}}</td>
			  	    		<td>{{certificate.matricula}}</td>
			  	    		<td>{{certificate.cpf}}</td>
			  	    	</tr>
			  	    </tbody>
			  	</table>
			</div>
		</form>
	</div>
</template>

<script>
	 //import vueMask from 'vue-jquery-mask';
	
	export default {
		props: ['eventsProp', 'templatesProp', 'certificatesProp'],
		//components: {vueMask},
		data: function() {
			return {
				success: '',
				error: '',
				events: null,
				templates: null,
				template: '',
				certificates: null,
				found: '',
				eventId: '',
				cpf: '',
				matricula: '',
				email: '',
				attendant_name: '',
				emitDisabled: true,
			} 
		},
		mounted: function() {
			this.events = this.eventsProp;
			this.templates = this.templatesProp;
		},
		watch: {
			cpf: function() {
				let cpf = this.cpf;
				if(cpf.length == 11 && this.found == '') {
					this.enableEmit();
					this.findStudent({type: 'cpf', value: cpf});
				} else if(cpf.length < 11) this.reset();
			},
			matricula: function() {
				if(this.matricula.length == 9 && this.found == '') {
					this.enableEmit();
					this.findStudent({type: 'matricula', value: this.matricula});
				} else if(this.matricula.length < 9) this.reset();
			}

		},
		methods: {
			findStudent: function(input) {
				axios.get('/admin/estudante/' + input.value)
					.then(response => {
						if(response.data.student.length) {
							this.found = true;

							let student = response.data.student[0];
							if(input.type == 'cpf') {
								this.email = student.email;
								this.matricula = student.matricula;
								this.attendant_name = student.nome;
							}
							else if(input.type == 'matricula') {
								this.cpf = student.cpf;
								this.email = student.email;
								this.attendant_name = student.nome;
							}
						}
						else this.found = false;
					});
			},
			onEventChange: function(event) {
				let eventId = event.target.value;
				this.fetchCertificates(eventId);
			},
			fetchCertificates: function(eventId) {
				axios.get('/admin/certificados/evento/' + eventId)
					.then(response => {
						this.certificates = response.data.certificates;
					});
			},
			reset: function() {
				this.emitDisabled = true;
				this.found = '';
			},
			disableEmit: function() {this.emitDisabled = true;},
			enableEmit: function() {this.emitDisabled = false;},
			onSubmit: function() {
				this.success = '';
				if(!this.eventId) {
					alert('Nenhum evento selecionado.');
					return;
				}
				axios.post('/admin/certificados/emitir', 
					{event_id: this.eventId,
					 template: this.template,
					 cpf: this.cpf, 
					 matricula: this.matricula,
					 email: this.email,
					 attendant_name: this.attendant_name})
					.then(response => {
						this.success = response.data;
						this.fetchCertificates(this.eventId);
					}).catch(error => {
						this.success = error.response.data;
					});
			}
		},
	}
</script>

<style>
	#emit-group {
		border: 1px solid #CBD2D9; 
		padding-top: 20px; 
		border-radius: 4px
	}
	#certificates_table {
		border: 1px solid #CBD2D9; 
		padding-top: 20px; 
		border-radius: 4px
	}
</style>