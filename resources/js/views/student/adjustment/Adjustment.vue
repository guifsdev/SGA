<template>
	<component 
		v-bind:is="stage"
		v-on:confirm="onConfirm"
		v-on:home="onHome"
		v-on:modify="onModify">
	</component>
</template>

<style scoped>
	>>> select, >>> button {
		font-size: 1.4rem;
	}
</style>

<script>
import AdjustmentForm from './AdjustmentForm.vue';
import AdjustmentConfirmForm from './AdjustmentConfirmForm.vue';

	export default {
		components: {AdjustmentForm, AdjustmentConfirmForm},
		props: {student: {type: Object}},
		data: function() {
			return {
				stage: 'adjustment-form',
				max_adjustments: null,
				periods: null,
				subjects: null,
				adjustments: null,
				success: null,
				pending_adjustments: [],
				open: false,
				closed_temporarily: false,
			}
		},
		methods: {
			onConfirm: function(data) {
				this.adjustments = data;
				this.stage = 'adjustment-confirm-form';
			},
			onModify: function() {
				this.stage = 'adjustment-form';
			},
			onHome: function() {
				this.$router.push({path: '/home'});
			}
		},
		mounted: function() {
			axios.get('estudante/adjustment/index', {
				params: {'student_id': this.student.id}
			})
				.then(response => {
					this.open = response.data.open;
					if(this.open) {
						this.max_adjustments = response.data.max_adjustments;
						this.periods = response.data.periods;
						this.subjects = response.data.subjects;
						this.pending_adjustments = response.data.pending_adjustments;
						this.closed_temporarily = response.data.closed_temporarily;
					}
				});
		}
		
	}
</script>
