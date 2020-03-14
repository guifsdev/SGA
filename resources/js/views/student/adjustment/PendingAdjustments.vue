<template>
	<v-container>
		<h1 class="table-title">Requerimentos enviados</h1>
		<v-data-table
			:headers="headers"
			:items="adjustments"
			hide-default-footer
			dense
			class="elevation-1">
		</v-data-table>
		<hr>
	</v-container>
</template>

<script>
export default {
	props: ['adjustments'],
	data: function() {
		return {
			headers: [
				{ text: 'Disciplina', value: 'subject.name_class' },
				{ text: 'Ação', value: 'action' },
				{ text: 'Status', value: 'result' },
				{ text: 'Resultado', value: 'reason_denied' },
			],
		}
	},
}
</script>

<style lang="scss" scoped>
hr {
	margin-top: 3rem;
}
</style>
