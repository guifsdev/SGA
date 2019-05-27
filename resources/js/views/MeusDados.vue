<template>
	<div class="container" v-if="student">
	    <div class="card" style="width: 18rem;">
	      <ul class="list-group list-group-flush">
	        <li class="list-group-item"><span class="font-weight-bold">CR:</span> {{student.cr}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">CHA:</span> {{student.cha}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">CHC:</span> {{student.chc}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">CHT:</span> {{student.cht}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Localidade:</span> {{student.localidade}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Currículo:</span> {{student.curriculo}}</li>
	      </ul>
	    </div>

	    <form method="POST">
	        <div class="form-group">
	            <label for="cpf">CPF:</label>
	            <input type="text" class="form-control" id="cpf" placeholder="Sua matrícula" 
	                name="cpf" disabled="disabled"
	                :value="student.cpf">
	        </div>
	    
	        <div class="form-group">
	            <label for="matricula">Matrícula:</label>
	            <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
	                name="matricula" disabled="disabled"
	                :value="student.matricula">
	        </div>
	        <div class="form-group">
	            <label for="nome">Nome completo:</label>
	            <input 
					disabled 
	            	type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome"
	                :value="student.nome">
	        </div>
	        <div class="form-group">
	            <label for="email">Email:</label>
	            <input type="email" class="form-control" id="email" name="email" required 
	                v-model="student.email">
	        </div>
	    
	        <div class="form-group">
	            <label for="telefone">Telefone:</label>
	            <input type="tel" class="form-control" id="telefone" name="tel" required
	                v-model="student.tel">
	        </div>
	        <div class="form-group align-center">
	            <button 
	            	@click.prevent="updateStudent"
	            	:disabled="loading"
	            	type="submit" class="btn btn-primary" id="atualizar" aria-describedby="aviso">
	            	<span 
	            		v-if="loading"
	            		class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
	            		{{loading ? 'Salvando...' : 'Salvar Alterações'}}
	            	</button>
	        </div>
	        <div class="alert alert-success" role="alert" v-if="success">
	          	{{success.message}}
	        </div>
	        <div class="alert alert-danger" role="alert" v-if="errors.length">
	        	<ul v-for="error in errors">
	        		<li>{{error}}</li>
	        	</ul>
	        </div>
	    </form>
	</div>
</template>

<script>
	export default {
		props: ['studentProps'],
		data: function() {
			return {
				student: null,
				loading: false,
				success: '',
				errors: [],
			}
		},
		methods: {
			updateStudent: function() {
				this.success = false;
				this.loading = true;
				this.errors = [];
				axios.patch('/estudante/update', {
					email: this.student.email,
					tel: this.student.tel,

				}).then(response => {
					this.success = response.data;
					this.loading = false;
				}).catch(error => {
					if(error.response) {
						let errors = error.response.data.errors; 
						Object.keys(errors).forEach(entry => {
							this.errors.push(errors[entry][0]);
						});
					}
					this.loading = false;
				});
			}
		},
		mounted: function() {
			this.student = this.studentProps;
		}
	}
</script>