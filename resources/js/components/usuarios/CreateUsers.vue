<template>
	<div class="container">
		<form @submit.prevent="onSubmit">
		  <div class="form-group">
		    <label for="nome">Nome</label>
		    <input 
		    	v-model="user.name"
		    	type="text" 
		    	class="form-control" 
		    	id="nome"
		    	placeholder="Nome">
		  </div>
		  <div class="form-group">
		    <label for="email">Email</label>
		    <input 
		    	v-model="user.email"
		    	type="email" 
		    	autocomplete="email" 
		    	class="form-control" id="email" 
		    	placeholder="name@example.com">
		  </div>
		  <div class="form-group">
		    <label for="cpf">CPF</label>
		    <vue-mask 
		        class="form-control" 
		        id="cpf"
		        v-model="user.cpf"
		        mask="000.000.000-00" 
		        :raw="false"> 
		    </vue-mask>
		  </div>
		  <div class="form-group">
		    <label for="password">Senha</label>
		    <input 
		    	v-model="user.password"
			    type="password" 
			    autocomplete="current-password" 
			    class="form-control" 
			    id="password" 
			    placeholder="Senha">
		  </div>
		  <div class="form-group">
		    <label for="cargo">Administrador</label>
			<select 
				v-model="user.is_admin"
				class="custom-select custom-select-sm" 
				id="is_admin">
			  <option value="1">Sim</option>
			  <option value="0">Não</option>
			</select>
		  </div>
		  <div 
		  	v-if="success"
		  	:class="success.status ? 'alert-success' : 'alert-danger'"
		  	class="alert" role="alert">
		    {{success.message}}
		  </div>
		  <button type="submit" class="btn btn-primary">Salvar</button>
		</form>
	</div>
</template>

<script>
	import vueMask from 'vue-jquery-mask';

	export default {
		components: {vueMask},
		data: function() {
			return {
				success: '',
				user: {
					name: '',
					email: '',
					cpf: '',
					password: '',
					is_admin: '',

				}
			}
		},
		methods: {
			onSubmit: function() {
				this.user.cpf = this.user.cpf.replace(/[\.-]/g, '');
				axios.post('/admin/usuarios/criar', this.user)
					.then(response => {
						this.success = response.data;
					})
					.catch(error => {
						this.success = error.response.data;
					});
			}
		}
	}
</script>