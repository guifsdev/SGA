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
					ref="adjustment"
					:configs="configs.adjustment"
					v-on:update="onUpdate"
					v-on:fail="onFailure"
					v-on:success="onSuccess">
				</adjustment-config>
			</v-tab-item>

			<v-tab-item value="Chamados">
				<calls-config 
					ref="calls"
					:configs="configs.calls"
					v-on:fail="onFailure"
					v-on:update="onUpdate"
					v-on:success="onSuccess">
				</calls-config>
			</v-tab-item>

			<v-tab-item value="IdUFF Crawler">
				<crawler-config 
					ref="crawler"
					:configs="configs.crawler"
					v-on:fail="onFailure"
					v-on:update="onUpdate"
					v-on:success="onSuccess">
				</crawler-config>
			</v-tab-item>

			<v-tab-item value="Certificados">
				<v-card flat tile>
					<v-card-text>
						<p>Certificados</p>
					</v-card-text>
				</v-card>
			</v-tab-item>

			<v-tab-item value="Configurações Gerais">
				<general-config></general-config>
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
import CrawlerConfig from './CrawlerConfig';
import GeneralConfig from './GeneralConfig';

export default {
	components: {AdjustmentConfig, CallsConfig, CrawlerConfig, GeneralConfig},
	data () {
		return {
			snackbar: {
				show: false,
				color: null,
				message: '',
			},
			tabs: ['Ajuste', 'Certificados', 'Chamados', 'IdUFF Crawler', 'Configurações Gerais'],
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
		onUpdate: function({configs}) {
			let context = configs.context;
			//console.log(configs); return;
			axios.post('servidor/configs/update', { configs })
				.then(response => {
					if(response.status == 200) {
						this.configs[context] = response.data[context];
						this.onSuccess();
					} else this.onFailure();
				});
		}
	},
	mounted: function() {
		axios.get('servidor/configs/index')
			.then(response => {
				this.configs = response.data;
			});
	},
	computed: {
		getTabsNames: function() {
			return [...this.tabs.map(tab => {return tab.name})];
		},
		getTabsContexts: function() {
			return [...this.tabs.map(tab => {return tab.context})];
		}
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
