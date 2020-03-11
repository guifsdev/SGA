<template>
	<v-app>
		<v-tabs>
			<v-tab 
				v-for="(tab, index) in tabs"
				:href="'#' + tab"
				:key="index">
				{{tab}}
			</v-tab>
			
			<v-tab-item value="Ajuste"> 
				<adjustment-config 
					ref="adjustmentConfigs"
					v-on:update="onUpdate"
					v-on:created="onCreated"
					v-on:fail="onFailure"
					v-on:success="onSuccess">
				</adjustment-config>
			</v-tab-item>

			<v-tab-item value="Chamados">
				<calls-config 
					ref="callsConfigs"
					v-on:fail="onFailure"
					v-on:created="onCreated"
					v-on:success="onSuccess">
				</calls-config>
			</v-tab-item>

			<v-tab-item value="Certificados">
				<v-card flat tile>
					<v-card-text>
						<p>Certificados</p>
					</v-card-text>
				</v-card>
			</v-tab-item>
		</v-tabs>
		<!--Snackbar-->
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
import AdjustmentConfig from './AdjustmentConfig';
import CallsConfig from './CallsConfig';

export default {
	components: {AdjustmentConfig, CallsConfig},
	data () {
		return {
			snackbar: {
				show: false,
				color: null,
				message: '',
			},
			tabs: ['Ajuste', 'Certificados', 'Chamados'],
			configs: {},
		}
	},
	methods: {
		onSuccess: function() {
			this.snackbar.show = true;
			this.snackbar.color = 'success';
			this.snackbar.message = 'Alterações salvas com sucesso.';
		},
		onFailure: function() {
			this.snackbar.color = 'error';
			this.snackbar.message = 'Ops... Algo deu errado!';
		},
		onCreated: function(name) {
			this.$nextTick(function() {
				switch(name) {
					case "Chamados": this.$refs.callsConfigs.setConfigs(this.configs.calls); break;
				}
			})
		},
		fetchConfigs: function() {
			axios.get('servidor/configs/index')
				.then(response => {
					this.configs = response.data;
					this.$refs.adjustmentConfigs.setConfigs(this.configs.adjustment);
				});
		},
		onUpdate: function(configs) {
			axios.post('servidor/configs/update', {configs})
				.then(response => {
					if(response.status == 200) {
						this.onSuccess();
						this.$refs.adjustmentConfigs.setAdjustmentStatus(response.data.adjustment)
					} else { this.onFailure(); }
				});
		}
	},
	mounted: function() {
		this.fetchConfigs();
	}
}
</script>

<style lang="scss" scoped>
.v-tab:hover {
	text-decoration: none;
}
label {
	display: block;
	width: 15rem;
}
.v-input {
	max-width: 16rem;
}
.row {
	margin-bottom: 1.2rem;
	&:nth-child(7) label {
		margin-top: 2rem;
	}
}
.v-time-picker-title {
	font-size: 3rem !important;
}
</style>
