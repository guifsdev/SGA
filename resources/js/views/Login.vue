<template>
	<v-app>
		<div class="login">
			<v-form 
				class="login__form"
				ref="form"
				v-bind:action="url" method="post"
				v-on:submit.prevent="onSubmit($event)">

				<img class="login__logo" src="/img/logo.svg" alt="Logo do SGA">
				<h1 class="heading-1 login__heading">Bem vindo ao sistema acadêmico do <span class="bold">SGA</span>!</h1>
				<p class="login__text mb-md">Aqui você tem acesso ao ambiente digital da coordenação do seu curso  de Administração (UFF - Niterói) e pode resolver tudo sem preocupações com papelada e burocracia.</p>
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
					class="mb-sm"
					name="password" 
					v-model="password"
					v-bind:label="passwordLabel"
					prepend-icon="lock" 
					type="password"/>
				<v-btn 
					type="submit"
					v-bind:disabled="loading"
					v-bind:loading="loading"
					color="$color-primary"
					class="login__btn btn btn-primary mb-sm">Login</v-btn>
				<v-alert v-if="errors.length" dense outlined type="error">
					{{getErrors()}}
				</v-alert>
			</v-form>
			<!--shapes-->
			<img class="login__shapes" src="/img/shapes.svg" alt="">
		</div>
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
		getErrors: function() {
			return this.errors.join("\n");
		},
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
@import "~global/_variables.scss";

.login {
	position: relative;
	display: flex;
	width: 100%;
	height: 100vh;
	@media screen and (max-width: 64em) { //1024px
		flex-direction: column;
		background-color: $color-white;
	}
	&::after {
		content: "";
		display: block;
		width: 100%;
		height: 100%;
		background-image: 
			linear-gradient(to right, 
				rgba($color-secondary, .16),
				rgba($color-secondary, .16)
			),
			url('/img/uff.jpg');
		background-size: cover;
		opacity: .8;
		@media screen and (max-width: 64em) { //1024px
			order: -1;
			clip-path: polygon(0 0, 100% 0, 100% 80%, 0 55%);
			margin-bottom: -30rem;
		}
		@media screen and (max-width: 38.5em) { //600px
			background-image: none;
			clip-path: none;
			background: url('/img/shapes.svg');
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 33%;
			background-size: cover;
			transform: rotate(180deg);
		}
	}
	&__form {
		display: flex;
		flex-direction: column;
		flex: 0 0 45rem;
		z-index: 20;
		padding: 3rem;
		& > * {
			flex-grow: 0;
		}
		@media screen and (max-width: 64em) { //1024px
			position: absolute;
			top: 50%;
			left: 50%;
			min-width: 45rem;
			background-color: #fff;
			border-radius: .5rem;
			box-shadow: 0 2rem 5rem rgba($color-grey-dark-1, .2);
			transform: translate(-50%, -50%);
		}
		@media screen and (max-width: 38.5em) { //600px
			min-width: 90%;
			padding: 1.5rem;
		}

	}
	&__logo {
		align-self: flex-start;
		width: 8rem;
		margin-bottom: 2rem;
		@media screen and (max-width: 64em) { //1024px
			align-self: center;
			width: 10rem;
		}
	}
	&__heading .bold {
		color: $color-primary;
		font-weight: 800;
	}
	&__text {
		font-size: 1.4rem;
		color: $color-grey-dark-3;
	}
	&__btn {
		align-self: flex-start;
		width:50%;
		@media screen and (max-width: 64em) { //1024px
			width: 100%;
		}
	}
	&__shapes {
		position: absolute;
		width: 100%;
		z-index: 10;
		bottom: 0;
		right: 0;
	}
}
</style>

