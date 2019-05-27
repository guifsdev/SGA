<template>
    <form>
    	<div class="alert alert-success .alert-dismissible" role="alert" v-if="updates || insertions">
    	  <h4 class="alert-heading">Sucesso!</h4>
    	  <p>A tabela de estudantes foi atualizada com êxito.</p>
    	  <hr>
    	  <p class="mb-0">Foram realizadas {{insertions}} inserções e {{updates}} atualizações.</p>
    	</div>
        <label for="file">Atualizar estudantes ativos:</label>
        <div class="input-group mb-3" style="max-width: 700px">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" accept=".csv" class="custom-file-input" id="file" name="file" @change="preProcess">
            <label class="custom-file-label">{{file ? file.name : 'Choose file'}}</label>
          </div>
        </div>
        <button type="button" class="btn btn-primary" id="update_students" :disabled="!file || loading" @click.prevent="handleFile">
        	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loading"></span>
        	{{loading ? 'Processando...' : 'Atualizar'}}
        </button>
        
        <div class="alert alert-warning" role="alert" style="margin-top: 16px">
          <span class="font-weight-bold">Importante:</span> para atualizar a tabela de estudantes ativos selecione o arquivo no formato .CSV com as seguintes colunas (não necessariamente nesta ordem): <br><samp>matricula, cpf, nome, cr, chc, cha, cht, curriculo</samp><br>
          <span class="font-weight-bold">Última atualização:</span> {{lastUpdate}}
        </div>
    </form>
</template>

<script>
	export default {
		data: function() {
			return {
				file: null,
				loading: false,
				insertions: null,
				updates: null,
				lastUpdate: null,

			}
		},
		methods: {
			preProcess: function(event) {
				this.loading = true;
			    // Check for the various File API support.
				if (window.FileReader) { // FileReader is supported.
					this.file = event.target.files[0];
					//handleFile(this.file);
				} else {
					alert('FileReader não é suportado nesse browser.');
				}
				this.loading = false;
			},
			handleFile: function() {
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
			      	axios.post('/admin/estudantes/merge', {csv: csv})
			      		.then((response) => {

			      			vm.insertions = response.data.insertions;
			      			vm.updates = response.data.updates;
			      			vm.loading = false;
			      			vm.lastUpdate = new Date().toLocaleString();
			      		}).catch((error) => {
			      			alert(`${error}: Falha ao processar o arquivo .csv. Verifique se as colunas estão nomeadas corretamente e tente novamente.`);
			      			vm.loading = false;
			      		});

			    }

			    function errorHandler(evt) {
					if(evt.target.error.name == "NotReadableError") {
						alert("Canno't read file!");
					}
			    }

		  	}
		},
		created: function() {
			let vm = this;
			axios.get('/api/admin/settings')
				 .then(response => {
				 	vm.lastUpdate = response.data;
				 })
		}
	}
</script>