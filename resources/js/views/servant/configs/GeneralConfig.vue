<template>
	<v-card flat tile>
		<v-dialog v-model="dialog" width="500">
			<template v-slot:activator="{ on }">
				<v-btn v-on="on" small dark 
					color="red lighten-2">Ativar modo de manutanção
				</v-btn>
			</template>

			<v-card>
				<v-card-title class="headline grey lighten-2" primary-title>
					Confirmação
				</v-card-title>

				<v-card-text>
					Deseja realmente ativar o modo de manutenção? <br>
					Por favor, insira a senha para modo de manutenção abaixo.
					<v-text-field
						class='password-field'
						v-model="password"
						label="Senha"
						:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
						:type="showPassword ? 'text' : 'password'"
						@click:append="showPassword = !showPassword"
					></v-text-field>
				</v-card-text>

				<v-divider></v-divider>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="primary" text
						@click="dialog = false">
						Cancelar
					</v-btn>
					<v-btn color="primary" text
						:disabled="password.length < 6"
						@click="setMaintenanceMode">
						Sim
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
		<template>
			<div class="text-center ma-2">
				<v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="2500">
					{{snackbar.message}}
					<v-btn dark text @click="snackbar.show = false"> Close </v-btn>
				</v-snackbar>
			</div>
		</template>
	</v-card>
</template>

<script>
export default {
	data () {
		return {
			dialog: false,
			showPassword: false,
			password: '',

			snackbar: {
				show: false,
				color: null,
				message: '',
			},
		}
	},
	methods: {
		setMaintenanceMode: function() {
			let vm = this;
			vm.dialog = false;
			let password = vm.password
			let params = {password};
			axios.get('down', { params })
				.then(response => {
					vm.snackbar.color = 'success';
					vm.snackbar.message = 'Alterações salvas com sucesso.';
					window.setTimeout(function() {
						window.location.href = '/';
					}, 3000);
				})
				.catch(error => {
					vm.snackbar.color = 'error';
					vm.snackbar.message = error.response.data.error;
				})
				.finally(response => {
					vm.snackbar.show = true;
				})
		}
	}
}
</script>

<style lang="scss" scoped>
.v-snack__content .v-btn{
	height: auto !important;
}
.password-field {
	max-width: 20rem;
}
.v-card .v-btn:first-child {
	margin: 2rem;
}
.v-card__text {
	margin-top: 1.5rem;
}
</style>
