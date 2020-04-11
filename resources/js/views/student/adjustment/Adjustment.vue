<template>
	<component 
		class="student-adjustment"
		ref="context"
		:root="$data"
		v-bind:is="component"
		v-on:confirm="onConfirm"
		v-on:home="onHome"
		v-on:modify="onModify">
	</component>
</template>


<script>
import AdjustmentForm from './AdjustmentForm.vue';
import AdjustmentConfirmForm from './AdjustmentConfirmForm.vue';

export default {
	components: {
		AdjustmentForm, 
		AdjustmentConfirmForm, 
	},
	props: {student: {type: Object}},
	data: function() {
		return {
			component: 'adjustment-form',
			open: null,
			status: null,
			max_adjustments: null,
			periods: null,
			subjects: null,
			adjustments: null,
			pending_adjustments: [],
			submited: null,
			recover: false,
			loading: true,
			success: null,
		}
	},
	methods: {
		onConfirm: function(data) {
			this.adjustments = data.adjustments;
			this.submited = data.submited;
			this.component = 'adjustment-confirm-form';
		},
		onModify: function() {
			this.adjustments = this.submited;
			this.recover = true;
			this.component = 'adjustment-form';
		},
		onHome: function() {
			this.$router.push({path: '/home'});
		}
	},
	mounted: function() {
		axios.get('estudante/adjustment/index', { params: {'student_id': this.student.id} })
			.then(response => {
				this.loading = false;
				Object.keys(response.data).forEach(data => {
					this[data] = response.data[data];

				})
				this.$refs.context.onReady();
			});
	}

}
</script>

<style scoped>
>>> select, >>> button {
	font-size: 1.4rem;
}
</style>
