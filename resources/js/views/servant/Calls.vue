<template>
	<v-app>
		<v-data-table
			v-on:click:row="viewCall($event)"
			:headers="headers"
			:items="calls"
			:items-per-page="5"
			class="elevation-1">
			<template v-slot:item.has_attachment="{item}">
				<v-icon 
					size="1.8rem !important"
					v-if="item.has_attachments" class="attachment-icon">attachment</v-icon>
			</template>
			<template v-slot:item.title="{item}">
				<span class="ellipsis borderless align-left">{{item.title}}
				</span>
			</template>
			<template v-slot:item.student="{item}">
				<span class="borderless align-left">{{item.student.full_name}}</span>
			</template>
		</v-data-table>
		<template>
			<div class="text-center">
				<v-dialog v-model="dialog" width="500">
					<v-card v-if="selected">
						<v-card-title 
							class="headline grey lighten-2" primary-title >
							{{selected.student.full_name}}: {{selected.issue}}
						</v-card-title>

							<v-card-text class="call">
								<h1 class="call__title">{{selected.title}}</h1>
								<p class="call__description">{{selected.description}}</p>
								<hr>
								<i :class="{'attachments-caret--open': viewAttachments}"
									class="fas fa-caret-right attachments-caret"></i>
								<a @click="showAttachments()">Arquivos anexados </a>
								<div class="call__attachments-box" :class="{'call__attachments-box--visible': viewAttachments}">
									<ul>
										<li 
											v-for="( attachment, index ) in selected.attachments" :key="index">
											<a 
												@click.prevent="getAttachment(index)"
												href="#">
												<i class="fas fa-link"></i>
												{{attachment.file_original_name}}
											</a>
										</li>
									</ul>
								</div>

								<hr>
								<label>Alterar status para:</label>
								<v-select 
									v-model="selected.status"
									:items="statuses" solo>
								</v-select>
							  <hr>
								<label>Resultado:</label>
								<v-textarea 
									v-model="selected.result"
									outlined name="input-7-4" label="Resposta ao chamado"></v-textarea>
							</v-card-text>

							<v-divider></v-divider>

							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="primary" 
									text 
									@click="respondCall">
									Salvar
								</v-btn>
							</v-card-actions>
					</v-card>
				</v-dialog>
			</div>
		</template>
		<!--Snackbar-->
		<template>
			<div class="text-center ma-2">
				<v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="2500">
					{{snackbar.message}}
					<v-btn dark text @click="snackbar.show = false"> Close </v-btn>
				</v-snackbar>
			</div>
		</template>
	</v-app>
</template>

<script>

export default {
	data() {
		return {
			dialog: false,
			result: '',
			status: '',
			headers: [
				{text: '#', value: 'id'},
				{text: 'Nome', value: 'student.full_name'},
				//{text: 'Matrícula', value: 'student.enrolment_number'},
				{text: 'CPF', value: 'student.cpf'},
				{text: 'Assunto', value: 'issue'},
				{text: 'Título', value: 'title'},
				{text: '', value: 'has_attachment'},
				{text: 'Criado em', value: 'created_at'},
				{text: 'Status', value: 'status'},
				{text: 'Resolvido em', value: 'resolved_at'},
			],
			calls: [],
			selected: null,
			statuses: [],
			viewAttachments: false,

			snackbar: {
				show: false,
				color: null,
				message: '',
			},
		}
	},
	mounted: function() {
		this.fetchCalls();
	},
	methods:  {
		respondCall () {
			let vm = this;
			vm.dialog = false;

			let selected = vm.selected;
			let status = selected.status;
			let result = selected.result;

			let callId = selected.id;

			let params = { status, result };
			axios.get(`servidor/calls/${callId}/edit`, {params})
				.then(response => {
					if(response.status == 200) {
						this.calls.map((call, index) => {
							if(call.id == callId) {
								this.calls[index] = Object.assign(this.calls[index], response.data.call);
							}
						})
						this.$forceUpdate();

						vm.snackbar.color = 'success';
						vm.snackbar.message = response.data.message;
					}
				})
				.catch(error => {
					vm.snackbar.message = error.response;
					vm.snackbar.color = 'error';
				})
				.finally(response => {
					vm.snackbar.show = true;
				})
				
		},
		getAttachment (index) {
			let vm = this;
			let callId = vm.selected.id;
			let attachment = vm.selected.attachments[index];
			axios({
				url: `servidor/call/${callId}/attachment/${attachment.id}`,
				method: 'GET',
				responseType: 'arraybuffer',
			})
			.then((response) => {
				const url = window.URL.createObjectURL(new Blob([response.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', attachment.file_original_name); //or any other extension
				document.body.appendChild(link);
				link.click();
			});
		},
		fetchCalls: function() {
			axios.get('servidor/calls/index')
				.then(response => {
					this.calls = response.data.calls;
					this.statuses = response.data.statuses;
				});
		},
		viewCall: function(event) {
			this.selected = event;
			this.dialog = true;
		},
		showAttachments: function() {
			this.viewAttachments = this.viewAttachments ? false : true;
		}
	}
}
</script>

<style lang="scss" scoped>
label {
	margin-bottom: 1rem;
}
tr:hover {
	cursor: pointer;
}
span {
	display: block;
	&.borderless {
		border-bottom: none !important;
	}
	&.ellipsis {
		white-space: pre;
		max-width: 28rem;
		overflow: hidden;
		text-overflow: ellipsis;
		height: 1.6rem;
	}
}
.call {
	&__description {
		margin-bottom: 2rem;
	}
	&__title {
		font-size: 1.5rem !important;
		display: block;
		margin: 1.5rem auto;
	}
	&__attachments-box {
		display: none;
		transition: display 1s;
		i { margin-right: 1.5rem; }
		&--visible {
			display: block;
		}
		ul {
			margin: 1.3rem auto;
		}
	}
	& .attachments-caret {
		&--open {
			transform: rotate(90deg);
		}
	}
}
</style>
