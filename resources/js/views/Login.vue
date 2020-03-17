<template>
	<v-app id="inspire" class="login">
		<v-content>
			<v-container class="fill-height" fluid>
				<v-row align="center" justify="center">
					<v-col cols="12" sm="8" md="4">
						<v-card class="elevation-12">
							<v-toolbar color="primary" dark flat>
								<v-toolbar-title class="login__title">Login em Aplicações SGA</v-toolbar-title>
							</v-toolbar>
							<v-card-text>
								<v-form 
									ref="form"
									v-bind:action="url" method="post"
									v-on:submit.prevent="onSubmit($event)">
									<v-select 
										@change="loginTypeChanged($event)"
										:items="loginTypes" 
										v-model="loginAs"
										label="Fazer login como">
									</v-select>
									<v-text-field 
										label="Seu CPF" 
										return-unmasked-value
										v-mask="cpfMask"
										name="cpf" 
										v-model="cpf"
										prepend-icon="person" 
										type="text"/>
									<v-text-field 
										id="password"
										name="password" 
										v-model="password"
										v-bind:label="passwordLabel"
										prepend-icon="lock" 
										type="password"/>
									<v-card-actions>
										<v-spacer/>
											<v-btn 
												v-bind:disabled="loading"
												v-bind:loading="loading"
												min-width="12rem"
												color="primary" type="submit">Login</v-btn>
										</v-card-actions>
								</v-form>
							</v-card-text>
						</v-card>
					</v-col>
					<template 
						v-if="errors.length">
						<v-col cols="12" sm="8" md="4">
							<v-alert 
								text prominent type="error" icon="mdi-cloud-alert">
								{{errors.join('\n')}}
							</v-alert>
						</v-col>
					</template>
				</v-row>
			</v-container>
		</v-content>
	</v-app>
</template>

<script>
import {TheMask} from 'vue-the-mask'

export default {
	//props: [ 'csrf' ],
	components: {TheMask},
	data: () => ({
		//csrf: document.head.querySelector('meta[name="csrf-token"]').content,
		loginTypes: ['Aluno', 'Servidor'],
		loginAs: 'Aluno',
		passwordLabel: 'Sua senha do idUFF',
		cpfMask: '###.###.###-##',
		cpf: '',
		password: '',
		url: 'estudante/login',
		errors: [],
		loading: false,

	}),
	methods: {
		onSubmit: function(event) {
			this.loading = true;
			let cpf = this.cpf.replace(/[.-]/g, '');
			let password = this.password;

			let vm = this;
			axios.post(this.url, {cpf, password})
				.then(response => {
					if(response.status == 200) {
						let route = this.url.split('/')[0];
						//Ugly...
						window.location.href = route;
					}
				})
				.catch(error => {
					this.loading = false;
					this.errors = [];
					let errors = error.response.data.errors;
					Object.keys(errors).forEach(key => {
						this.errors.push(errors[key][0]);
					});
				});
		},
		loginTypeChanged: function(value) {
			switch(value) {
				case "Aluno": {
					this.passwordLabel = "Sua senha do idUFF";
					this.url = "estudante/login";
					break;
				}
				case "Servidor": {
					this.passwordLabel = "Senha";
					this.url = "servidor/login";
					break;
				}
			}
		}
	},

}
</script>

<style lang="scss" scoped>
.login .container.fill-height > .row {
	max-width: none;
}
</style>

