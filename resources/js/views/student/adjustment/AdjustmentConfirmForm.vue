<template>
	<v-app>
		<pending-adjustments 
			v-if="root.pending_adjustments.length"
			:adjustments="root.pending_adjustments">
		</pending-adjustments>
		
		<v-container>
			<h1 class="table-title">Novo ajuste</h1>
			<v-data-table
				:headers="headers"
				hide-default-footer
				dense
				:items="root.adjustments"
				class="elevation-1">
			</v-data-table>


			<div class="btn-box">
				<v-btn 
					@click="save"
					:disabled="btnDisabled"
					:loading="loading"
					small color="primary">Salvar
				</v-btn>
				<v-btn 
					@click="$emit('modify')"
					:disabled="btnDisabled"
					small color="primary">Alterar
				</v-btn>
			</div>
			<v-alert v-if="errors.length" type="error">
				<ul>
					<li v-for="( error, index) in errors" :key="index">{{error}}</li>
				</ul>
			</v-alert>
			<v-alert v-if="success.status"
				dense text type="success" >
				<p>{{success.message}}</p>
				<p><strong>Assinatura:</strong> {{success.signature}}</p>
			</v-alert>
			<template>
				<div class="text-center ma-2">
					<v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="2500">
						{{snackbar.message}}
						<v-btn dark text @click="snackbar.show = false"> Close </v-btn>
					</v-snackbar>
				</div>
			</template>
		</v-container>
	</v-app>
</template>

<style lang="scss" scoped>
.btn-box {
	margin: 1.8rem 0;

}
</style>

<script>
import PendingAdjustments from './PendingAdjustments.vue';

export default {
	props: ['root'],
	components: {
		PendingAdjustments,
	},
	data: function() {
		return {
			btnDisabled: false,
			snackbar: {
				show: false,
				color: null,
				message: '',
			},
			errors: [],
			loading: false,
			success: { status: false, message: null, signature: null },
			headers: [
				{
					text: 'Período',
					align: 'start',
					sortable: false,
					value: 'period',
				},
				{ text: 'Disciplina', value: 'subject.name_class' },
				{ text: 'Ação', value: 'action' },
			],
		}
	},
	methods: {
		save: function() {
			this.loading = true;
			
			//console.log(this.root.adjustments); return;

			axios.post('/estudante/adjustment/store',
				{ student: this.$parent.student,
				  adjustments: this.root.adjustments })
				.then(response => {
					if(response.status == 200 && response.data.success) {
						this.success.message = response.data.message;
						this.success.signature = response.data.signature;
						this.btnDisabled = true;
						this.success.status = true;
						this.loading = false;
					}
				})
				.catch(err => {
					let errors = [];
						Object.keys(err).forEach(key => {
							errors.push(err[key].data);
					});
					this.errors = errors[errors.length - 1];
					this.loading = false;
					this.snackbar.color = 'error';
					this.snackbar.message = this.errors.message;
					this.snackbar.show = true;
					this.loading = false;
				});

		}
	},
}
</script>
