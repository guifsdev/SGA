<template>
	<div class="container" v-if="student">
	    <div class="card" style="width: 18rem;">
	      <ul class="list-group list-group-flush">
	        <li class="list-group-item"><span class="font-weight-bold">CR:</span> {{student.performance_coeficient}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Carga horária obtida:</span> {{student.obtained_workload}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Carga horária cursada:</span> {{student.attended_workload}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Carga horária total:</span> {{student.total_workload}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Situação:</span> {{student.current_status}}</li>
	        <li class="list-group-item"><span class="font-weight-bold">Percentual concluído:</span> {{student.percentage_completed + "%"}}</li>
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
	                :value="student.enrolment_number">
	        </div>
	        <div class="form-group">
	            <label for="nome">Nome completo:</label>
	            <input 
					disabled 
	            	type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome"
					:value="`${student.first_name} ${student.last_name}`">
	        </div>
	        <div class="form-group">
	            <label for="email">UFF Mail:</label>
	            <input 
					type="email" disabled="disabled"
	 				class="form-control" id="email" name="email" required 
	                v-model="student.email_primary">
	        </div>
	        <div class="form-group">
	            <label for="email">Email alternativo:</label>
	            <input disabled="disabled" type="email" class="form-control" id="email" name="email" required 
	                v-model="student.email_secondary">
	        </div>
	    
	        <div class="form-group">
	            <label for="telefone">Telefone:</label>
	            <input disabled="disabled" type="tel" class="form-control" id="telefone" name="tel" required
	                v-model="student.cell_phone_number">
	        </div>
	    </form>
	</div>
</template>

<script>
	export default {
		props: {student: {type: Object}},
		data: function() {
			return { }
		},
		methods: {
			//updateStudent: function() {
				//this.success = false;
				//this.loading = true;
				//this.errors = [];
				//axios.patch('/estudante/update', {
					//email: this.student.email,
					//tel: this.student.tel,

				//}).then(response => {
					//this.success = response.data;
					//this.loading = false;
				//}).catch(error => {
					//if(error.response) {
						//let errors = error.response.data.errors; 
						//Object.keys(errors).forEach(entry => {
							//this.errors.push(errors[entry][0]);
						//});
					//}
					//this.loading = false;
				//});
			//}
		},
		mounted: function() {
		}
	}
</script>
