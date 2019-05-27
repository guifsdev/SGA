<template>
	<div class="container" v-if="$parent.student">
		<form id="student_data" @submit.prevent="processAdjustments($event)">
			<div class="form-group">
				<label for="cpf">CPF:</label>
				<input 
					:value="$parent.student.cpf" 
					readonly 
					name="cpf"
					type="text" class="form-control" id="cpf" placeholder="CPF">
			</div>
		
			<div class="form-group">
				<label for="matricula">Matrícula:</label>
				<input 
					:value="$parent.student.matricula" 
					readonly 
					name="matricula"
					type="text" class="form-control" id="matricula" placeholder="Sua matrícula">
			</div>
			<div class="form-group">
				<label for="nome">Nome completo:</label>
				<input 
					:value="$parent.student.nome" 
					readonly 
					name="nome"
					type="text" class="form-control" id="nome" placeholder="Seu nome">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input 
					v-model="$parent.student.email"
					name="email"
					type="email" class="form-control" id="email" required>
			</div>
		
			<div class="form-group">
				<label for="telefone">Telefone:</label>
				<input 
					v-model="$parent.student.tel"
					name="tel"
					type="tel" class="form-control" id="telefone" required>
			</div>
		
			<table class="table table-sm">
			  <thead>
			    <tr>
			      <th scope="col" style="text-align: center; width: 15%">Período</th>
			      <th scope="col" style="text-align: center">Disciplina</th>
			      <th scope="col" style="text-align: center; width: 15%">Ação</th>
		
			    </tr>
			  </thead>
			  <tbody>
				  <tr v-for="(n, index) in numAdjustments">
				  	<td>
						<select 
							@change="fetchSubjects($event, index)"
							name="period"
							class="custom-select custom-select-sm">
							<option value="">Selecione</option>
						  	<option v-for="p in periods">{{p}}</option>
						</select>
				  	</td>
				  	
				  	<td>
						<select 
							name="subject"
							class="custom-select custom-select-sm" ref="subjects">
						  	<option disabled value="0">Selecione</option>
		
						</select>
				  	</td>
				  	
				  	<td class="align-radio-center">
				  		<select 
				  			name="action" 
				  			class="custom-select custom-select-sm">
				  			<option value="">Selecione</option>
				  			<option value="1">Incluir</option>
				  			<option value="0">Excluir</option>
				  		</select>
				  	</td>
				  </tr>
		
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button
					class="btn btn-primary" id="confirm" aria-describedby="aviso">Ajustar plano de estudos</button>
			</div>
		</form>
		<div
			v-if="errors.length"
			class="alert alert-danger" role="alert">
		  	<ul>
		  		<li v-for="error in errors">{{error}}</li>
		  	</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {
				adjustments: null,
				periods: 8,
				numAdjustments: null,
				errors: [],
			}
		},
		methods: {
			fetchSubjects: function(event, index) {
			 	let dest = this.$refs.subjects[index];
				
				let def = dest.firstChild;

				while(dest.firstChild) dest.removeChild(dest.firstChild);
				dest.appendChild(def);

				if(!event.target.value) return;

				axios.get('/subjects/' + event.target.value)
					 .then(response => {
					 	response.data.forEach(subject => {
					 		//console.log(subject);

					 		let option = document.createElement('option');
					 		option.textContent = `${subject.name} ${subject.class_name}`;
					 		option.value = [subject.id, subject.name + ' ' + subject.class_name];
					 		dest.appendChild(option);
					 	})
					 });
			},
			processAdjustments: function(event) {
				this.clearErrors();
				let formData = Array.from(new FormData(event.target));
				//remove empty values
				formData = formData.filter(entry => {return entry[1] != ''});

				//count to check if periods, subjects and actions are same
				let counts = {};
				let adjustments = []; 
				let adjustment = {};
				formData.forEach(entry => {
					if(['period', 'subject', 'action'].includes(entry[0])) {
						if(entry[0] == 'subject') {
							let subject = entry[1].split(',');
							adjustment['subject_id'] = subject[0];
							adjustment['subject_name'] = subject[1];
						} else adjustment[entry[0]] = entry[1];
						if(Object.keys(adjustment).length == 4) {
							adjustments.push(adjustment);
							adjustment = {};
						}
						if(counts.hasOwnProperty(entry[0])) counts[entry[0]]++;
						else counts[entry[0]] = 1;
					}
				});
				if(Object.keys(counts).length < 3 || 
					(counts.subject != counts.period) || 
					(counts.subject != counts.action)) {
					this.errors.push('Erro no preenchimento do formulário.');
					return;
				}
				//console.log(adjustments);
				this.$emit('confirm', adjustments);
				
			},
			clearErrors: function() {
				this.errors = [];
			},
		},
		created: function() {
			axios.get('/setting/max-ajustes')
				.then(response => {
					this.numAdjustments = response.data;
				});
		}
	}
</script>

<style>
	
</style>