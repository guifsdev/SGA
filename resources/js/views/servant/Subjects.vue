<template>
<v-app>
	<v-container class="subjects">
		<v-container class="btn-box clearfix">
			<v-btn 
				@click="openFileInput">Atualizar</v-btn>

			<v-btn 
				@click="exportCsv">Exportar CSV</v-btn>
		</v-container>
		<v-container ref="file-input-box" 
			   v-bind:class="{'file-input-box--active': showFileInput}" 
			class="file-input-box clearfix">
			<v-row no-gutters="">
				<v-col cols="12" sm="12">
					<v-alert
						border="top"
						colored-border
						type="info"
						elevation="2">
						Selecione um arquivo com extensão <code>.csv</code> e use os headers: <kbd>"code","name","period","class_name","offered"</kbd><br>
						<strong>Descrição e tipo de dado em cada coluna:</strong><br>
						<ul>
							<li><kbd>code</kbd> (Texto) Código da disciplina. (ex: "STA00123");</li>
							<li><kbd>name</kbd> (Texto) Nome da disciplina. (ex: "Finanças Públicas");</li>
							<li><kbd>period</kbd> (Numérico) Período;</li>
							<li><kbd>class_name</kbd> (Texto) Nome da turma. (ex: "P2");</li>
							<li><kbd>offered</kbd> (Numérico[0|1]) A disciplina é offertada? 1 se sim, 0 se não.</li>
						</ul>
						<strong>Importante:</strong> As disciplinas serão completamente <em>substituídas</em> pelo conteúdo do arquivo enviado!
					</v-alert>
				</v-col>
			</v-row>
			<v-row no-gutters>
				<v-col cols="12" sm="6">
					<v-file-input 
						accept="text/csv"
						@change="preProcess($event)"
						label="File input" outlined dense></v-file-input>
				</v-col>
				<v-col cols="12" sm="3">
					<v-btn 
						class="btn-save"
						:loading="loading"
						color="primary"
						@click="handleFile"
						width="10rem">Enviar</v-btn>
				</v-col>
			</v-row>
		</v-container>
		<v-container>
			<v-data-table
		  :headers="headers"
		  :items="subjects"
		  :multi-srot="true"
		  :items-per-page="5">
			</v-data-table>
		</v-container>
	</v-container>
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
	data: () => ({
		subjects: [],
		errors: [],
		file: null,
		loading: false,
		showFileInput: false,
		headers: [
			{text: 'Código', value: 'code'},
			{text: 'Nome', value: 'name'},
			{text: 'Período', value: 'period'},
			{text: 'Turma', value: 'class_name'},
			{text: 'Oferecida', value: 'offered_text'},
		],

		snackbar: {
			show: false,
			color: null,
			message: '',
		},
	}),
	mounted: function() {
		this.fetchSubjects();
	},
	methods: {
		exportCsv: function() {
			axios({
				url: 'servidor/subjects/index?csv=true',
				method: 'GET',
				responseType: 'blob', // important
			})
			.then((response) => {
				const url = window.URL.createObjectURL(new Blob([response.data]));
				const link = document.createElement('a');
				link.href = url;
				link.setAttribute('download', 'subjects.csv'); //or any other extension
				document.body.appendChild(link);
				link.click();
			});
			//axios.get('servidor/subjects/index', {params: {csv: true}})
				//.then(response => {

				//})
		},
		fetchSubjects: function() {
			axios.get('servidor/subjects/index')
				.then(response => {
					this.subjects = response.data.subjects;
				});
		},
		openFileInput: function() {
			this.showFileInput = this.showFileInput ? false : true;
		},
		preProcess: function(file) {
			this.loading = true;
			// Check for the various File API support.
			if (window.FileReader) { // FileReader is supported.
				this.file = file;
				//handleFile(this.file);
			} else {
				alert('FileReader não é suportado nesse browser.');
			}
			this.loading = false;
		},
		handleFile: function() {
			if(!this.file) return;
			this.loading = true;
			let reader = new FileReader();
			// Read file into memory as UTF-8      
			reader.readAsText(this.file);
			// Handle errors load
			reader.onload = loadHandler;
			reader.onerror = errorHandler;
			function loadHandler(event) {
				let csv = event.target.result;
				processData(csv);
			}
			let vm = this;
			function processData(csv) {
				axios.post('servidor/subjects', {csv})
					.then((response) => {
						if(response.status == 200) {
							vm.snackbar.color = 'success';
							vm.snackbar.message = response.data;
							vm.fetchSubjects();
						}
					}).catch((err) => {
						vm.loading = false;
						vm.errors = [];
						let errors = err.response.data;
						vm.errors.push(errors);
						vm.snackbar.color = 'error';
						vm.snackbar.message = vm.errors.join('\n');

					}).finally(() => {
						vm.loading = false;
						vm.snackbar.show = true;
					});
			}
			function errorHandler(evt) {
				if(evt.target.error.name == "NotReadableError") {
					alert("Canno't read file!");
				}
			}
		}
	},
}

</script>

<style lang="scss" scoped>
.row:last-child {
	max-height: 3rem;
}
.clearfix::after {

	content: "";
	clear: both;
	display: table;
}
.file-input-box {
	display:  none;
	&--active {display: block;}
	.btn-save {
		margin-left: 1rem;
		height: 4rem;
	}
	li:not(:last-child) {
		margin-bottom: .5rem;
	}
}
.btn-box {
	padding-top: 0;
	padding-bottom: 0;
	.v-btn {
		float: right;
		&:first-child {
			margin-left: 1rem;
		}
	}
}
.container {
	padding-left: 0;
	padding-right: 0;
	&.subjects {
		padding-top: 0;
	}
}
</style>
