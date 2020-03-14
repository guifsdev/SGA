<template>
	<v-app>
		<div v-if="root.loading" class="d-flex justify-content-center">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>

		<template v-else>
			<pending-adjustments 
				v-if="root.pending_adjustments.length"
				:adjustments="root.pending_adjustments">
			</pending-adjustments>

			<v-alert 
				v-if="!root.open || root.status != 'open'"
				text prominent type="error" icon="mdi-cloud-alert">
				{{message}}
			</v-alert>

			<v-container v-else class="adj">
				<h1 class="table-title">Novo ajuste</h1>
				<v-row class="adj__tbl-header" no-gutters>
					<v-col class="col" cols="12" sm="2"><b>Período</b></v-col>
					<v-col class="col" cols="12" sm="7"><b>Disciplina</b></v-col>
					<v-col class="col" cols="12" sm="3"><b>Ação</b></v-col>
				</v-row>
				<v-row v-for="( row, index ) in maxRows" :key="index">
					<v-col class="" cols="12" sm="2">
						<v-select
							@change="periodChanged($event, index)"
							ref="period"
							v-model="adjustments[index].period"
							:items="periods"
							label="Período"
							dense solo>
						</v-select>
					</v-col>
					<v-col cols="12" sm="7" class="col">
						<v-select
							v-bind:items="adjustments[index].allSubjects"
							@change="subjectChanged($event, index)"
							v-model="adjustments[index].allSubjects[0]"
							ref="subject"
							label="Disciplina"
							dense solo>
						</v-select>
					</v-col>
					<v-col cols="12" sm="3" class="col">
						<v-select
							ref="action"
							v-model="adjustments[index].action"
							:items="actions"
							label="Ação"
							dense solo>
						</v-select>
					</v-col>
				</v-row>
				<div class="btn-box">
					<v-btn 
						@click="validateAdjustments"
						small color="primary">Salvar</v-btn>
				</div>
			</v-container>
		</template>
		<div v-if="errors.length"
		   class="alert alert-danger" role="alert">
			<ul>
				<li v-for="error in errors">{{error}}</li>
			</ul>
		</div>
	</v-app>
</template>

<script>
import PendingAdjustments from './PendingAdjustments.vue';

export default {
	components: {
		PendingAdjustments,
	},
	props: ['root'],
	data: function() {
		return {
			adjustments: [],
			errors: [],
			subjects: [],
			actions: ['Incluir', 'Excluir'],
			saveBtnDisabled: true,
		}
	},
	computed: {
		periods: function() {
			return [...Array(this.root.periods).keys()]
				.filter(p => {return p > 0});
		},
		message: function() {
			let message = '';
			if(this.root.status == 'closed_temporarily') {
				message = 'Ajuste momentaneamente suspenso. Aguarde...';
				return message;
			}
			if(!this.root.open) message = 'Aguarde a data de abertura do ajuste.';
			return message;
		},
		maxRows: function() {
			return this.root.max_adjustments - 1;
		}
	},
	created: function() {
		if(this.$parent.recover) {
			this.recover();
		}
	},
	methods: {
		recover: function() {
			this.adjustments = this.$parent.$data.submited;
		},
		onReady: function() {
			for(let i = 0; i < this.maxRows; ++i) {
				let adjustment = { period: null, subject: null, action: null, ids: [], allSubjects: [] };
				this.adjustments.push(adjustment);
			}
		},
		subjectChanged: function(subject, index) {
			this.adjustments[index].subject = this.root.subjects
				.filter(el => {
					return subject == el.name_class;
				})[0];
		},
		periodChanged: function(period, index) {
			this.adjustments[index].period = period;
			this.adjustments[index].ids = [];
			this.adjustments[index].allSubjects = [];

			let subjects = this.root.subjects
				.filter(subject => { return subject.period == period })
				.map(subject => { 
					this.adjustments[index].allSubjects.push(subject.name_class);
					this.adjustments[index].ids.push(subject.id);
				});
			let firstSubject = this.adjustments[index].allSubjects[0];
			this.subjectChanged(firstSubject, index);
		},
		validateAdjustments: function() {
			this.clearErrors();
			//Eww!
			let adjustments = JSON.parse(JSON.stringify(this.adjustments));
			let submited = JSON.parse(JSON.stringify(this.adjustments));


			adjustments = adjustments.filter(adjustment => {
				return adjustment.period != null;
			})
			let invalid = adjustments.filter(adjustment => {
				return adjustment.action == null;
			})
			if(invalid.length || !adjustments.length) {
				this.errors.push('Erro no preenchimento do formulário.');
				return;
			}
			adjustments.map(adjustment => {
				delete adjustment['ids'];
				delete adjustment['allSubjects'];
			})
			this.checkPendings(submited, adjustments);
		},
		checkPendings: function(submited, adjustments) {
			//check for already sent and pending adjustments
			let pending = [];
			adjustments.forEach(adjustment => {
				let subject = this.root.pending_adjustments
					.filter((pendingAdjustment) => {
					return pendingAdjustment.subject_id == adjustment.subject.id;
				});
				if(subject.length) pending.push(subject);
			});
			
			if(pending.length) {
				this.errors.push('Você já tem requerimento em pelo menos uma das disciplinas.');
				return;
			}
			this.$emit('confirm', {submited, adjustments});
		},
		clearErrors: function() {
			this.errors = [];
		},
	},
}
</script>

<style lang="scss" scoped>
.adj {
	.mdi {
		font-size: 1.6rem !important;
	}
	.table-title {
		margin-bottom: 1.8rem; 
	}
	.btn-box {
		margin-top: 2rem;
	}
	.v-input__control {
		min-height: auto !important;
	}
	.row {
		&:first-child {
			border-bottom: 1px solid #dee2e6;
			border-top: 1px solid #dee2e6;
			padding: .3rem;
			margin-bottom: -.5rem;
		}
		&:not(:first-child) {
			margin-bottom: -4rem;
		}

	}
	&__tbl-header {
		.col {
			text-align: center;
			//&:first-child {padding-right: 2rem;}
		}
	}
}
</style>
