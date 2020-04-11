<template>
	<v-app>
		<template v-if="pending.length">
			<pending-calls
				:calls="pending">
			</pending-calls>
		</template>
		<ValidationObserver ref="observer" v-slot="{ validate, reset }">
		<v-container>
			<h1>Criar um novo chamado</h1>
			<form 
				action="estudante/calls" 
				method="post" 
				enctype="multipart/form-data">
				<ValidationProvider v-slot="{ errors }" name="O assunto" rules="required|min:1">
					<v-select 
						v-bind:value="getIssues[0]"
						v-model="issue"
						@change="change($event)"
						:items="configs.issues"
						:error-messages="errors"
						label="Assunto"
						:disabled="callSent"
						required>
					</v-select>
				</ValidationProvider>
				
				<ValidationProvider v-slot="{ errors }" name="Este campo" :rules="`${isOtherIssue ? 'required|max:80' : ''}`">
					<v-text-field 
						v-if="isOtherIssue"
						v-model="otherIssue"
						:counter="80"
						:error-messages="errors"
						:disabled="callSent"
						label="Especifique o outro assunto" required></v-text-field>
				</ValidationProvider>

				<ValidationProvider v-slot="{ errors }" name="O título" rules="required|max:80">
					<v-text-field v-model="title"
						:counter="80"
						:error-messages="errors"
						:disabled="callSent"
						label="Título" required></v-text-field>
				</ValidationProvider>
				
				<ValidationProvider v-slot="{ errors }" name="A descrição" rules="max:1000">
					<v-textarea 
						v-model="description"
						:error-messages="errors"
						counter=1000
						:disabled="callSent"
						required
						label="Descrição">
					</v-textarea>
				</ValidationProvider>

				<ValidationProvider v-slot="{ validate, errors }" 
					ref="fileValidator" name="Anexos" 
					:rules="`size:${configs.attachments.max_size}`"> 
					<v-file-input 
						v-model="attachments"
						:counter="configs.attachments.max_num"
						@change="handleFileChange"
						multiple 
						:disabled="callSent"
						name="attachments"
						show-size
						chips
						label="Anexar arquivos (opcional)">
					</v-file-input>
						<span class="error--text v-messages__message v-messages__message--file-error">{{errors[0]}}</span>
				</ValidationProvider>
				<v-row>
					<v-col cols="12" sm="12">
						<v-btn 
							:loading="loading"
							:disabled="disabled" 
							class="mr-4" color="primary" @click="submit">Enviar</v-btn>
						<v-alert 
							v-if="success.status"
							class="success-message"
							text type="success" >
							<p>{{success.message}}</p>
							<p><strong>Assinatura:</strong> {{success.signature}}</p>
						</v-alert>
					</v-col>
				</v-row>
			</form>
		</v-container>
		</ValidationObserver>
	</v-app>
</template>

<script>
import PendingCalls from './PendingCalls.vue';

import { required, max, min, size } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
setInteractionMode('eager')
extend('required', {
	...required,
	message: '{_field_} não pode ser vazio.',
})
extend('min', {
	...min,
	message: '{_field_} não pode ser vazio.',
})
extend('max', {
	...max,
	message: '{_field_} não deve conter mais do que {length} caracteres.',
})
extend('size', {
	...size,
	message: '{_field_} não devem ser maiores que {size} kb.',
})
export default {
	components: {
		ValidationProvider,
		ValidationObserver,
		PendingCalls,
	},
	data: () => ({
		pending: [],
		success: {},
		errors: null,
		title: '',
		issue: '',
		attachments: [],

		isOtherIssue: false,
		otherIssue: '',

		configs: {
			issues: [], 
			attachments: {}},

		loading: false,
		description: '',
		disabled: false,
		callSent: false,
	}),
	methods: {
		async handleFileChange(files) {
			const {valid} = await this.$refs.fileValidator.validate(files);
			let vm = this;
			let max = vm.configs.attachments.max_num;
			if(files.length > max) {
				vm.$refs.fileValidator.errors.push(`A quantidade de anexos não deve ser maior que ${max}.`);
				vm.disabled = true;
			}
			else this.disabled = false;
		},
		async submit (e) {
			const isValid = await this.$refs.observer.validate();

			if(isValid) {
				let vm = this;
				vm.loading = true;
				vm.disabled = true;
				//Submit call
				let issue = vm.isOtherIssue ? vm.otherIssue : vm.issue;
				let description = vm.description;
				let title = vm.title;
				let student_id = vm.$attrs.student.id;
				let cpf = vm.$attrs.student.cpf;
				let formData = new FormData();
				let settings = { headers: { 'content-type': 'application/json' } };
				
				if(vm.attachments.length) {
					settings.headers['content-type'] = 'multipart/form-data'; 

					vm.attachments.map(attachment => {
						formData.append('files[]', attachment);
					})
				}
				formData.append('data', JSON.stringify({description,issue, title, student_id, cpf}));
				vm.callSent = true;
				axios.post('estudante/calls', formData, settings)
					.then(response => {
						let vm = this;
						if(response.status == 200) {
							vm.success.status = true;
							vm.success.message = response.data.message;
							vm.success.signature = response.data.signature;
						}
					})
					.catch(error => {
						console.log(error.response);
					})
					.finally(response => {
						vm.loading = false;
					});
			}
		},
		change (value) {
			if(value === "Outro") {
				this.isOtherIssue = true;
			}
			else this.isOtherIssue = false;

		},
		getIssues () {
			return this.configs.issues.unshift('');
		}
	},
	mounted: function() {
		let vm = this;
		axios.get('estudante/calls/create?student_id=' + vm.$attrs.student.id)
			.then(response => {
				let data = response.data;

				vm.configs.issues = data.configs.issues;
				vm.configs.attachments = data.configs.attachments;
				vm.pending = data.pending;
				
			})
	}
}
</script>

<style lang="scss" scoped>
.success-message {
	width: 100%;
}
.v-btn {
	margin-bottom: 2rem;
	.v-icon { font-size: 2rem !important; }
}
.v-messages__message {
	&--file-error {
		display:block;
		margin: -1.3rem auto 2rem auto;

	}
}
.container {
	max-width: 80rem;
	margin-left: 0;
}
.v-textarea {
	margin-top: 1.4rem;
}
h1 {
	font-size: 2rem !important;
}
</style>
