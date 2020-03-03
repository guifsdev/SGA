<template>
	<v-app>
		<v-tabs>
			<v-tab 
				v-for="(tab, index) in tabs"
				:href="`#tab-${index}`"
				:key="index">
				{{tab}}
			</v-tab>
			
			<v-tab-item 
				v-for="(tab, index) in tabs"
				:value="'tab-' + index"
				:key="index">
				<v-card v-if="tab == 'Ajuste'" 
					flat tile>
					<v-card-text>
						<v-container>
							<!--Status-->
							<v-row align="center">
								<label for="" >Status: </label>
								<span style="font-weight: bold">{{}}</span>
							</v-row>
							<!--Opening date-->
							<v-row align="center">
								<label>Data de abertura: </label>
								<v-menu v-model="menu.date.open"
									:close-on-content-click="false"
									transition="scale-transition"
									offset-y
									min-width="290px">
									<template v-slot:activator="{ on }">
										<v-text-field v-model="adjustment.date.open"
											dense
											label="Picker in menu"
											readonly
											v-on="on">
										</v-text-field>
									</template>
									<v-date-picker 
										v-model="adjustment.date.open"
										no-title scrollable>
										<v-spacer></v-spacer>
											<v-btn text color="primary" @click="menu.date.open = false">Cancel</v-btn>
											<v-btn text color="primary" @click="menu.date.open = false">OK</v-btn>
									</v-date-picker>
								</v-menu>
							</v-row>
							<!--Opening time-->
							<v-row align="center">
								<label>Horário de abertura:</label>
								<v-menu v-model="menu.time.open" 
									:close-on-content-click="false" 
									:nudge-right="40" 
									transition="scale-transition" 
									offset-y 
									max-width="290px"
									min-width="290px" >
									<template v-slot:activator="{ on }">
										<v-text-field
											v-model="adjustment.time.open"
											label="Picker in menu"
											readonly
											v-on="on">
										</v-text-field>
									</template>
									<v-time-picker
										v-if="menu.time.open"
										v-model="adjustment.time.open"
										full-width
										@click:minute="menu.time.open = false">
									</v-time-picker>
								</v-menu>
							</v-row>
							<!--Closing date-->
							<v-row align="center">
								<label>Data de fechamento: </label>
								<v-menu 
									v-model="menu.date.close"
									:close-on-content-click="false"
									transition="scale-transition"
									offset-y
									min-width="290px">
									<template v-slot:activator="{ on }">
										<v-text-field 
											v-model="adjustment.date.close"
											dense
											label="Picker in menu"
											readonly
											v-on="on">
										</v-text-field>
									</template>
									<v-date-picker 
		    							v-model="adjustment.date.close"
										no-title scrollable>
										<v-spacer></v-spacer>
											<v-btn text color="primary" @click="menu.date.close = false">Cancel</v-btn>
											<v-btn text color="primary" @click="menu.date.close = false">OK</v-btn>
									</v-date-picker>
								</v-menu>
							</v-row>
							<!--Closing time-->
							<v-row align="center">
								<label>Horário de fechamento:</label>
								<v-menu v-model="menu.time.close" 
									:close-on-content-click="false" 
									:nudge-right="40" 
									transition="scale-transition" 
									offset-y 
									max-width="290px"
									min-width="290px" >
									<template v-slot:activator="{ on }">
										<v-text-field
											v-model="adjustment.time.close"
											label="Picker in menu"
											readonly
											v-on="on">
										</v-text-field>
									</template>
									<v-time-picker
										v-if="menu.time.close"
										v-model="adjustment.time.close"
										full-width
										@click:minute="menu.time.close = false">
									</v-time-picker>
								</v-menu>
							</v-row>
							<!--Close temporarily-->
							<v-row align="center">
								<label>Fechar temporariamente:</label>
								<v-switch v-model="adjustment.closed_temporarily"
									class="mx-2">
								</v-switch>
							</v-row>
							<!--Max number of subjects per adjustment-->
							<v-row align="center">
								<label>Número máximo de disciplinas por ajuste: </label>
								<v-text-field v-model="adjustment.max_adjustments"
									hide-details
									single-line
									type="number"
									min="1"/>
							</v-row>
							<!--Reasons to deny-->
							<v-row>
								<label>Razões para indeferimento:</label>
								<v-textarea 
									v-model="adjustment.reasons_to_deny"
									outlined name="input-7-4" 
									label=""
									hint="Separe os item com um ';' (semi-colon)">
								</v-textarea>
							</v-row>
							<v-row>
								<div class="my-2">
									<v-btn small color="primary" @click="setAdjustmentConfigs()">Salvar</v-btn>
								</div>
							</v-row>
						</v-container>
					</v-card-text>
				</v-card>
				<v-card v-if="tab == 'Certificados'" 
					flat tile>
					<v-card-text>
						<p>Certificados</p>
					</v-card-text>
				</v-card>
			</v-tab-item>
		</v-tabs>
	</v-app>
</template>

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

<script>
export default {
	data () {
		return {
			tabs: ['Ajuste', 'Certificados'],
			menu: {
				date: {
					open: false,
					close: false,
				},
				time: {
					open: false,
					close: false,
				}
			},
			adjustment: {
				date: {
					open: null,
					close: null,
				},
				time: {
					open: null,
					close: null,
				},
				closed_temporarily: false,
				max_adjustments: null,
				reasons_to_deny: null,
			},
			status: null,
		}
	},
	mounted: function() {
		this.getConfigs();
	},
	methods: {
		setAdjustmentConfigs: function() {
			let configs = this.adjustment;
			axios.post('servidor/configs/update', {configs})
				.then(response => {
					console.log(response.data);
				});
		},
		getConfigs: function() {
			axios.get('servidor/configs/index')
				.then(response => {
					let data = response.data;
					this.getAdjustmentConfigs(data.adjustment);
					//this.setCertificatesConfigs(data.certificate);
				});
		},
		getAdjustmentConfigs: function(configs) {
			//Get times
			let re = /\s(.+)$/;
			let times = {open: null, close: null};
			let dates = configs.date;

			times.open = dates.open.match(re)[1];
			times.close = dates.close.match(re)[1];

			dates.open = dates.open.replace(re, '');
			dates.close = dates.close.replace(re, '');

			configs.time = times;
			configs.date = dates;

			configs.reasons_to_deny = configs.reasons_to_deny.filter(config => {
				return config != "Outro";
			}).join('; ');

			this.adjustment = Object.assign(this.adjustment, configs);
		}
	}
}
</script>
