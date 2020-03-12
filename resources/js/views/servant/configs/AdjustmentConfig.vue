<template>
	<v-card
		flat tile>
		<v-card-text>
			<v-container>
				<!--Status-->
				<v-row class="config__row" align="center">
					<label class="config__label" for="" >Status: </label>
					<span style="font-weight: bold">{{status}}</span>
				</v-row>
				<!--Opening date-->
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Data de abertura: </label>
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
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Horário de abertura:</label>
					<v-menu v-model="menu.time.open" 
						class="config__time-picker"
						:close-on-content-click="false" 
						:nudge-right="40" 
						transition="scale-transition" 
						offset-y 
						max-width="290px"
						min-width="290px">
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
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Data de fechamento: </label>
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
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Horário de fechamento:</label>
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
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Fechar temporariamente:</label>
					<v-switch 
						v-model="adjustment.closed_temporarily"
						class="mx-2 ">
					</v-switch>
				</v-row>
				<!--Max number of subjects per adjustment-->
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Número máximo de disciplinas por ajuste: </label>
					<v-text-field v-model="adjustment.max_adjustments"
						hide-details
						single-line
						type="number" 
						min="1"/>
				</v-row>
				<!--Reasons to deny-->
				<v-row class="config__row">
					<label class="config__label">Razões para indeferimento:</label>
					<v-textarea 
						v-model="adjustment.reasons_to_deny"
						ref="reasons_to_deny"
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row">
					<div class="my-2">
						<v-btn small color="primary" @click="updateConfigs">Salvar</v-btn>
					</div>
				</v-row>
			</v-container>
		</v-card-text>
	</v-card>
</template>

<script>
export default {
	data () {
		return {
			//configs: {},
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
			context: 'adjustment',
		}
	},
	created: function() {
		this.$emit('created', this.context);
	},
	methods: {
		setConfigs: function(configs) {
			this.setAdjustmentConfigs(configs);
			this.checkStatus(configs);
		},
		updateConfigs: function() {
			let configs = this.adjustment;

			configs['context'] = this.context;
			this.$emit('update', {configs});

			this.setAdjustmentConfigs(this.adjustment);
			this.checkStatus(this.adjustment);

		},
		checkStatus: function(configs) {

			let today = new Date();

			let close = new Date(configs.date.close);

			if(configs.closed_temporarily) {
				this.status = "Fechado temporariamente";
				return;
			}
			
			this.status = today <= close ? "Aberto" : "Fechado";

		},
		setAdjustmentConfigs: function(configs) {
			let reasons = configs.reasons_to_deny;
			if(typeof reasons === 'object') {
				reasons = Object.keys(reasons)
					.map(key => { return reasons[key] })
					.join('; ');
			}
			configs.reasons_to_deny = reasons;

			//Get times
			let re = /\s(.+)$/;
			if(configs.date.open.match(re)) {
				let times = {open: null, close: null};
				let dates = configs.date;
				times.open = dates.open.match(re)[1];
				times.close = dates.close.match(re)[1];

				dates.open = dates.open.replace(re, '');
				dates.close = dates.close.replace(re, '');

				configs.time = times;
				configs.date = dates;
			}
			this.adjustment = Object.assign(this.adjustment, configs);
		}
	},
}
</script>

<style lang="scss" scoped>
</style>
