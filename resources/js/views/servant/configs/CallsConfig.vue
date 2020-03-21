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
						v-model="statuses"
						ref="statuses"
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
	props: ['configs'],
	data () {
		return {
			issues: "",
			statuses: "",
			max_num_attachments: null,
			context: 'calls',
		}
	},
	mounted: function() {
		this.setConfigs(this.configs);
	},
	watch: {
		configs: function() {
			this.setConfigs(this.configs);
		}
	},
	computed: {
		issuesList: {
			get: function() {
				let issues = this.issues.split(';').map(item => item.trim());
				let otter = issues.filter((item) => { return item.match(/^outro$/i) })[0];
				if(!otter) issues.push('Outro');
				return issues;
			}
		},
		statusesList: {
			get: function() {
				return this.statuses.split(';').map(item => item.trim());
			}
		}
	},
	methods: {
		setConfigs: function(configs) {
			let vm = this;
			Object.keys(configs).map(function(key) {
				if(typeof configs[key] === "object") {
					vm[key] = configs[key].join('; ');
				} else vm[key] = configs[key];

			});
		},
		updateConfigs: function() {
			let configs = {};
			configs.max_num_attachments = this.max_num_attachments;
			configs.issues = this.issuesList;
			configs.statuses = this.statusesList;
			configs['context'] = this.context;
			this.$emit('update', {configs});
		},
	},
}
</script>
