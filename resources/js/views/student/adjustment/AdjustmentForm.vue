<template>
	<div class="container" v-if="$parent.student">
		<div class="container" style="margin-bottom: 2rem;"
			v-if="$parent.pending_adjustments.length">
			<h3><b>Requerimentos enviados</b></h3>
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col">Disciplina</th>
						<th scope="col">Ação</th>
						<th scope="col">Status</th>
						<th scope="col">Resultado</th>
					</tr>
				</thead>
				<tr v-for="adjustment in $parent.pending_adjustments">
					<td>{{`${adjustment.subject.code} ${adjustment.subject.name} ${adjustment.subject.class_name}`}}</td>
					<td>{{adjustment.action}}</td>
					<td>{{adjustment.result}}</td>
					<td>{{adjustment.reason_denied}}</td>
				</tr>
			</table>
		</div>
		
		<div v-if="!$parent.open" class="alert alert-primary" role="alert">
			Aguarde a data de abertura do ajuste.
		</div>

		
		<form v-else @submit.prevent="processAdjustments($event)">
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col" style="text-align: center; width: 15%">Período</th>
						<th scope="col" style="text-align: center">Disciplina</th>
						<th scope="col" style="text-align: center; width: 15%">Ação</th>

					</tr>
				</thead>
				<tbody>
				  <tr v-for="(item, index) in $parent.max_adjustments">
					  <td>
						  <select name="period" class="custom-select custom-select-sm"
		  					@change="fetchSubjects($event, index)">
							  <option value="">Selecione</option>
							  <option v-for="p in $parent.periods">{{p}}</option>
						  </select>
					  </td>

					  <td>
						  <select name="subject" class="custom-select custom-select-sm" ref="subjects">
							  <option disabled value="0">Selecione</option>
						  </select>
					  </td>

					  <td class="align-radio-center">
						  <select name="action" class="custom-select custom-select-sm">
							  <option value="">Selecione</option>
							  <option value="1">Incluir</option>
							  <option value="0">Excluir</option>
						  </select>
					  </td>
				  </tr>
			  </tbody>
			</table>
			<div class="form-group align-center">
				<button class="btn btn-primary" id="confirm" aria-describedby="aviso">Ajustar plano de estudos</button>
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

<style scoped>
	select, button {
		font-size: 1.4rem;
	}
</style>

<script>
	export default {
		data: function() {
			return {
				adjustments: null,
				errors: [],
				subjects: [],
			}
		},
		methods: {
			fetchSubjects: function(event, index) {
				let select = this.$refs.subjects[index];
				let def = select.firstChild;

				while(select.firstChild) select.removeChild(select.firstChild);
				select.appendChild(def);

				if(!event.target.value) return;

				let selectedPeriod = event.target.value;
				let subjects = this.$parent.subjects.filter(subject => {
					return subject.period == selectedPeriod;
				});

				subjects.forEach(subject => {
					let option = document.createElement('option');
					option.textContent = `${subject.name} ${subject.class_name}`;
					option.value = [subject.id, subject.name + ' ' + subject.class_name];
					select.appendChild(option);
				});
			},
			processAdjustments: function(event) {
				this.clearErrors();
				let formData = Array.from(new FormData(event.target));
				//remove empty values
				this.validateForm(formData);
			},
			validateForm: function(formData) {
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

				//check for already sent and pending adjustments
				let pending = [];
				adjustments.forEach(adjustment => {
					let subject = this.$parent.pending_adjustments.filter((pendingAdjustment) => {
						return pendingAdjustment.subject_id == adjustment.subject_id;
					});
					if(subject.length) pending.push(subject);
				});
				
				if(pending.length) {
					this.errors.push('Você já tem requerimento em pelo menos uma das disciplinas.');
					return;
				}

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
		mounted: function() {
		}
	}
</script>

<style>
	
</style>
