<template>
	<v-card flat tile>
		<v-card-text>
			<v-container>
				<v-row class="config__row" align="center">
					<label class="config__label">Assuntos possíveis:</label>
					<v-textarea 
						v-model="issues" 
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row" align="center">
					<label class="config__label">Status possíveis:</label>
					<v-textarea 
						v-model="issues" 
						outlined name="input-7-4" 
						label=""
						hint="Separe os item com um ';' (semi-colon)">
					</v-textarea>
				</v-row>
				<v-row class="config__row config__row--small" align="center">
					<label class="config__label">Número máximo de anexos:</label>
					<v-text-field 
						hide-details
						single-line
						type="number" 
						min="0"/>
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
			name: 'Chamados',
		}
	},
	mounted: function() {
	},
	methods: {
		setConfigs: function(configs) {
			this.issues = configs.issues
		}
	},
	created: function() {
		this.$emit('created', this.name);
	}
}
</script>

<style>

</style>
