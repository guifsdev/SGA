<template>
	<v-card flat tile>
		<v-card-text>
			<v-container>
				<v-row 
					dense
					class="config__row config__row--small" align="center">
					<label class="config__label">Resincronizar dados em:</label>
					<v-text-field 
						v-model="configs.trigger.limit"
						hide-details
						single-line
						dense
						type="number" 
						min="1"/>
					<v-select
						v-model="configs.trigger.measure"
						:items="['hours', 'days', 'months', 'years']"
						dense solo>
					</v-select>
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
			trigger: {},
			context: 'crawler',
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
	methods: {
		setConfigs: function(configs) {
			this.trigger = configs; 
		},
		updateConfigs: function() {
			let configs = this.trigger;
			configs['context'] = this.context;
			this.$emit('update', {configs});

		}
	}
}
</script>

<style lang="scss" scoped>
label {
	line-height: 4rem;
}
.row {
	align-items: inherit !important;
}
.v-text-field {
	max-width: 10rem;
}
.v-select {
	max-width: 12rem;
	margin-left: 1.5rem;
}
</style>
