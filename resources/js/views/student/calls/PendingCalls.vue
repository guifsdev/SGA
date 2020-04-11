<template>
	<v-container>
		<h1 class="title">Chamados enviados</h1>
		<v-data-table
			:headers="headers"
			:items="calls"
			hide-default-footer
			dense
			class="elevation-1">
		</v-data-table>
		<hr>
	</v-container>
</template>

<script>
export default {
	props: ['calls'],
	data: function() {
		return {
			headers: [
				{ text: 'Assunto', value: 'issue' },
				{ text: 'Título', value: 'title' },
				{ text: 'Status', value: 'status' },
				{ text: 'Data chamado', value: 'created_at' },
				{ text: 'Resultado', value: 'result' },
			],
		}
	},
}
</script>

<style lang="scss" scoped>
.container {
	max-width: 100% !important;
	//padding: 0 !important;
}
hr {
	margin-top: 3rem;
}
</style>
