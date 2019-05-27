<template>
	<div class="container" v-if="event">
		<form 
			@submit.prevent="onSubmit"
			method="POST" 
			action="/admin/eventos/eventid">
			<div class="form-group">
				<label for="nome">Nome:</label>
				<input 
					v-model="event.nome"
					type="text" class="form-control" id="nome" name="nome" placeholder="Nome do evento">
			</div>
			 <div class="form-group">
				<label for="descricao">Descrição:</label>
	    		<textarea 
	    			v-model="event.descricao"
	    			class="form-control" name="descricao" id="descricao" rows="3">
	    			</textarea>
			</div>
			<div class="form-group">
				<label for="local">Local:</label>
				<input type="text" class="form-control" id="local" name="local" placeholder="Local do evento"
					v-model="event.local">
			</div>
			
			<div class="form-group">
				<label for="data">Data:</label>
				<input 
					v-model="event.data"
					type="datetime-local" class="form-control" id="data" name="data" placeholder="Data do evento">
			</div>
			
			<div class="form-group">
				<label for="tipo">Tipo (atividade complementar):</label>
				<input 
					v-model="event.tipo"
					type="text" class="form-control" id="tipo" name="tipo" placeholder="1, 2 ou 3">
			</div>
			<div class="form-group">
				<label for="duracao">Duração (em horas):</label>
				<input 
					v-model="event.duracao"
					type="number" class="form-control" min="1" step="1" id="duracao" name="duracao" placeholder="Duração do evento">
			</div>
			<div class="form-group">
				<label for="carga-horaria">Carga horária:</label>
				<input 
					v-model="event.carga_horaria"
					type="number" class="form-control" min="1" step="1" id="carga-horaria" name="carga_horaria" placeholder="Carga horária do evento">
			</div>
			<div class="form-group">
				<label for="organizador">Organizador:</label>
				<input 
					v-model="event.organizador"
					type="text" class="form-control" id="organizador" name="organizador" placeholder="Organizador do evento">
			</div>
			<!-- <div class="form-group">
				<label for="template">Template:</label>
				<select 
					class="form-control" id="template" name="template">
					<option 
						v-for="template in templates" 
						:value="template">{{template}}</option>
				</select>
			</div> -->
			<div class="form-group">
				<label for="metodo-inserir">Inserir participantes:</label>
				<select class="form-control" id="metodo-inserir" name="insertion-method">
					<option value="manual">Manual</option>
					<option value="csv">CSV</option>
				</select>
			</div>

			<div class="container form-group" 
			  	style="border: 1px solid #CBD2D9; padding: 20px; border-radius: 4px">
				<div class="container" id="manual">
					<table id="myTable" class="table order-list">
					    <thead>
					        <tr>
					            <th scope="col" style="width: 30%">Nome</th>
					            <th scope="col" style="width: 23%">CPF</th>
					            <th scope="col" style="width: 17%">Matrícula</th>
					            <th scope="col" style="width: 30%">Email</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr>
					            <td class="">
					                <input type="text" class="form-control" id="nome-participante" name="nome-participante[0]">
					            </td>
								<td class="">
					            	<input type="text" class="form-control" id="cpf-participante"  name="cpf-participante[0]">
								</td>
								<td class="">
									<input type="text" class="form-control" id="matricula-participante" name="matricula-participante[0]">
								</td>
								<td class="">
									<input type="email" class="form-control" id="email-participante" name="email-participante[0]">
								</td>

					            <td class=""><a class="deleteRow"></a></td>
					        </tr>
					    </tbody>
					    <tfoot>
					        <tr>
					            <td colspan="5" style="text-align: left;">
					                <input type="button" class="btn btn-light btn-block " id="addrow" value="Adicionar"/>
					            </td>
					        </tr>
					        <tr>
					        </tr>
					    </tfoot>
					</table>
				</div>

				<div class="container collapse" id="csv">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
					  </div>
					  <div class="custom-file">
					    <input type="file" accept=".csv" id="csv-file" class="custom-file-input">
					    <label class="custom-file-label" for="csv-file">Escolher arquivo</label>
					    <input type="hidden" id="file-contents" name="file-contents">
					  </div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<button 
					type="submit" class="btn btn-primary">Salvar</button>
			</div>

			<div 
				v-if="success"
				class="alert alert-success" role="alert">
				{{success.message}}
			</div>
		</form>
	</div>
</template>

<script>
	export default {
		props: ['eventProps'],
		data: function() {
			return {
				event: null,
				success: '',
			}
		},
		mounted: function() {
			this.event = this.eventProps;
			this.templates = this.templatesProps;
		},
		methods: {
			onSubmit: function() {
				//console.log(this.event);
				axios.patch('/admin/evento/' + this.event.id, this.event)
					.then(response => {
						this.success = response.data;
					})
			}
		}
	}
</script>