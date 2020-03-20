<template>
	<v-card flat tile>
		<v-card-text>
			<v-container>
				<v-row class="config__row" align="center">
					<label class="config__label">Assuntos possíveis:</label>
					<v-textarea 
						v-bind:value="getList('issues')"
						ref="issues"
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row" align="center">
					<label class="config__label">Status possíveis:</label>
					<v-textarea 
						v-bind:value="getList('statuses')"
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
	data () {
		return {
			issues: [],
			statuses: [],
			max_num_attachments: null,
			context: 'calls',
		}
	},
	computed: {
		getList: function(data) {
			return this[data].join('; ');
		}
	},
	methods: {
		setConfigs: function(configs) {
			//console.log(configs.issues);
			this.issues = configs.issues;
			this.statuses = configs.statuses;
		},
		updateConfigs: function() {
			let configs = this.$data;
			['issues', 'statuses'].forEach(data => {
				configs[data] = this.$refs[data].split(';')
					.map(data => issue.trim())
			});

			if(data == 'issues') {
				let otter = this.issues.filter((el) => {
					return el.match(/^outro$/i)
				})[0];
				if(!otter) configs.issues.push('Outro');
			}

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
