<template>
	<component 
		v-bind:is="stage"
		v-on:confirm="onConfirm"
		v-on:success="onSuccess"
		v-on:home="onHome"
		v-on:modify="onModify"></component>
</template>

<script>
import AjusteForm from './AjusteForm.vue';
import AjusteConfirmForm from './AjusteConfirmForm.vue';
import AjusteSuccess from './AjusteSuccess.vue';
import AjusteFechado from './AjusteFechado.vue';

	export default {
		components: {AjusteForm, AjusteConfirmForm, AjusteSuccess, AjusteFechado},
		props: ['studentProps'],
		data: function() {
			return {
				stage: '',
				student: null,
				adjustments: null,
				success: null,
				open: false,
			}		
		},
		methods: {
			onConfirm: function(data) {
				this.adjustments = data;
				this.stage = 'ajuste-confirm-form';
			},
			onModify: function() {
				this.stage = 'ajuste-form';
			},
			onSuccess: function(data) {
				this.success = data;
				this.stage = 'ajuste-success';
			},
			onHome: function() {
				this.$router.push({path: '/home'});
			}
		},
		mounted: function() {
			this.student = this.studentProps;

			axios.get('/ajuste/status')
				.then(response => {
					this.open = response.data.open;
					this.stage = this.open ? 'ajuste-form' : 'ajuste-fechado';
				});
		}
		
	}
</script>