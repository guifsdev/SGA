<template>
	<v-app>
		<v-data-table
			v-on:click:row="viewCall($event)"
			:headers="headers"
			:items="calls"
			:items-per-page="5"
			class="elevation-1">
		</v-data-table>
		<template>
			<div class="text-center">
				<v-dialog v-model="dialog" width="500">
					<v-card v-if="selected">
						<v-card-title 
							class="headline grey lighten-2" primary-title >
							{{selected.student_name}}: {{selected.issue}}
						</v-card-title>

							<v-card-text class="call">
								<h1 class="call__title">{{selected.title}}</h1>
								<p class="call__description">{{selected.description}}</p>
								<hr>
								
								<label>Arquivos anexados 
									<i @click="showAttachments()" 
		    							:class="{'attachments-caret--open': viewAttachments}"
										class="fas fa-caret-right attachments-caret"></i>
								</label>
								<div class="call__attachments-box" :class="{'call__attachments-box--visible': viewAttachments}">
									<ul>
										<li><a href="#"><i class="fas fa-link"></i>Foo</a></li>
										<li><a href="#"><i class="fas fa-link"></i>Bar</a></li>
										<li><a href="#"><i class="fas fa-link"></i>Baz</a></li>
									</ul>
								</div>

								<hr>
								<label>Alterar status:</label>
								<v-select :items="status_list" v-model="status_list[0]" solo>
								</v-select>
							  <hr>
								<label>Resposta:</label>
								<v-textarea outlined name="input-7-4" label="Outlined textarea" 
									value="The Woodman set to work at once, and so sharp was his axe that the tree was soon chopped nearly through." ></v-textarea>
							</v-card-text>

							<v-divider></v-divider>

							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="primary" text @click="dialog = false" >
									Salvar
								</v-btn>
							</v-card-actions>
					</v-card>
				</v-dialog>
			</div>
		</template>
	</v-app>
</template>

<script>
export default {
	data() {
		return {
			dialog: false,
			headers: [
				{text: '#', value: 'id'},
				{text: 'Nome', value: 'student_name'},
				{text: 'Matrícula', value: 'enrolment_number'},
				{text: 'Assunto', value: 'issue'},
				{text: 'Título', value: 'title'},
				{text: 'Anexos', value: 'has_attachment'},
				{text: 'Criado em', value: 'created_at'},
				{text: 'Status', value: 'status'},
				{text: 'Resolvido em', value: 'resolved_at'},
			],
			calls: [],
			selected: null,
			status_list: [],
			viewAttachments: false,
		}
	},
	mounted: function() {
		this.fetchCalls();
	},
	methods:  {
		fetchCalls: function() {
			axios.get('servidor/calls/index')
				.then(response => {
					this.calls = response.data.calls;
					this.status_list = response.data.status_list;
				});
		},
		viewCall: function(event) {
			this.selected = event;
			this.dialog = true;
		},
		showAttachments: function() {
			console.log('showAttachments');
			this.viewAttachments = this.viewAttachments ? false : true;
		}
	}
}
</script>

<style lang="scss" scoped>
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
	}
	& .attachments-caret {
		&--open {
			transform: rotate(90deg);
		}
	}
}
</style>
