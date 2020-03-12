<template>
	<v-card flat tile>
		<v-card-text>
			<v-container>
				<v-row class="config__row" align="center">
					<label class="config__label">Assuntos possíveis:</label>
					<v-textarea 
						v-model="issues"
						ref="issues"
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row" align="center">
					<label class="config__label">Status possíveis:</label>
					<v-textarea 
						v-model="status_list"
						ref="status_list"
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Número máximo de anexos:</label>
					<v-text-field 
						v-model="max_num_attachments"
						hide-details
						single-line
						type="number" 
						min="0"/>
				</v-row>
				<v-row class="config__row">
					<div class="my-2">
						<v-btn small color="primary" @click="updateConfigs()">Salvar</v-btn>
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
			issues: null,
			status_list: null,
			max_num_attachments: null,
			context: 'calls',
		}
	},
	methods: {
		setConfigs: function(configs) {
			Object.keys(configs).forEach(key => {
				if(typeof configs[key] === 'object') {
					this[key] = configs[key].join('; ');
				} else this[key] = configs[key];
			});
		},
		updateConfigs: function() {
			let configs = this.$data;
			['issues', 'status_list'].forEach(data => {
				configs[data] = this[data].split(';')
					.map(issue => issue.trim())
				if(data == 'issues') {
					let otter = this.issues.filter((el) => {
						return el.match(/^outro$/i)
					})[0];
					if(!otter) configs.issues.push('Outro');
				}
			})
			this.$emit('update', {configs});
			this.setConfigs(configs);
		},
	},

	created: function() {
		this.$emit('created', this.context);
	},
}
</script>

<style>

</style>
