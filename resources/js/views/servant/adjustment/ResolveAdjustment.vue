<template>
	<v-app>
		<!--Filters Modal-->
		<div class="filters">
			<v-dialog 
				v-model="filtersModal" 
				width="600" >
				<template v-slot:activator="{ on }">
					<v-btn v-on="on" >Filtrar colunas</v-btn>
				</template>

				<v-card>
					<v-card-title class="headline grey lighten-2" primary-title>Filtrar colunas</v-card-title>
					<v-card-text>
						<v-container 
							fluid class="filters-container">
							<!--Filter type selector-->
							<v-row dense>
								<v-col class="d-flex" cols="12" sm="2">
									<p style="line-height: 4rem;">Tipo de filtro:</p>
								</v-col>
								<v-col class="d-flex" cols="12" sm="2">
									<v-select 
			 							ref="filter-type"
										v-model="filters.type"
										:items="['E', 'Ou']" 
										dense solo></v-select>
								</v-col>
							</v-row>
							<v-row 
								v-for="(column, index) in filters.active"
								:key="index"
								align="center" 
								dense>
								
								<!-- Column selector -->
								<v-col class="d-flex" cols="12" sm="4">
									<v-select 
										v-model="column.name"
										:items="filters.names" 
										@change="filterChanged($event, index)" 
										dense solo></v-select>
								</v-col>

								<!-- Column criteria -->
								<v-col class="d-flex" cols="12" sm="2">
									<v-select
										v-model="column.criteria_selected"
										:items="column.criteria"
										@change="criterionChanged($event, index)"
										dense solo></v-select>
								</v-col>

								<!-- Conditional inputs -->
								<v-col class="d-flex" cols="12" sm="6" >
									<v-text-field 
										v-if="column.type == 'text'"
		  								v-model="column.value"
										:label="column.name" dense></v-text-field>
									<v-select 
		  								v-else-if="column.type == 'select'"
		  								v-model="column.value"
										:items="column.values" dense solo></v-select>

									<!-- Date Picker for range-->
									<v-menu
										v-if="column.type == 'date' && column.criteria_selected == 'Entre'"
										ref="menu"
										v-model="dates[index].start"
										:close-on-content-click="false"
										:return-value.sync="date"
										transition="scale-transition"
										offset-y
										min-width="290px">
										<template v-slot:activator="{ on }">
											<!--Start Date-->
											<v-text-field
												dense
		  										v-bind:value="column.value[0]"
												v-model="column.value[0]"
												label="Picker in menu"
												readonly
												class="date-picker--dual"
												v-on="on">
											</v-text-field>
										</template>
										<v-date-picker v-model="column.value[0]" no-title scrollable>
											<v-spacer></v-spacer>
											<v-btn text color="primary" @click="dates[index].start = false">Cancel</v-btn>
											<v-btn text color="primary" @click="dates[index].start = false">OK</v-btn>
										</v-date-picker>
									</v-menu>
									<v-spacer></v-spacer>
									<v-menu
										v-if="column.type == 'date' && column.criteria_selected == 'Entre'"
										ref="menu"
										v-model="dates[index].end"
										:close-on-content-click="false"
										:return-value.sync="date"
										transition="scale-transition"
										offset-y
										min-width="290px">
										<template v-slot:activator="{ on }">
											<!--End Date-->
											<v-text-field
												dense
		  										v-bind:value="date"
												v-model="column.value[1]"
												label="Picker in menu"
												readonly
												v-on="on">
											</v-text-field>
										</template>
										<v-date-picker v-model="column.value[1]" no-title scrollable>
											<v-spacer></v-spacer>
											<v-btn text color="primary" @click="dates[index].end = false">Cancel</v-btn>
											<v-btn text color="primary" @click="dates[index].end = false">OK</v-btn>
										</v-date-picker>
									</v-menu>

									<!-- Date Picker for single-->
									<v-menu
										v-else-if="column.type == 'date' && 
											['Igual a', 'Antes de', 'Depois de'].includes(column.criteria_selected)"
										ref="menu"
										v-model="dates[index].equals"
										:close-on-content-click="false"
										:return-value.sync="date"
										transition="scale-transition"
										offset-y
										min-width="290px">
										<template v-slot:activator="{ on }">
											<v-text-field
												dense
												v-model="column.value"
												label="Picker in menu"
												readonly
												v-on="on">
											</v-text-field>
										</template>
										<v-date-picker v-model="column.value" no-title scrollable>
											<v-spacer></v-spacer>
											<v-btn text color="primary" @click="dates[index].equals = false">Cancel</v-btn>
											<v-btn text color="primary" @click="dates[index].equals = false">OK</v-btn>
										</v-date-picker>
									</v-menu>
								</v-col>
							</v-row>
						</v-container>
						<v-btn class="mx-2" fab dark color="primary" x-small @click="addRow">
							<v-icon dark>mdi-plus</v-icon>
						</v-btn>
					</v-card-text>

					<v-divider></v-divider>

					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="primary" text @click="removeFilters()">Remover Filtros</v-btn>
						<v-btn color="primary" text @click="applyFilters()">Aplicar filtros</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</div>
		<v-data-table
			 ref="data-table"
			:headers="headers"
			:items="adjustments"
			:show-select="showSelect"
			:multi-srot="true"
			item-key="id"
   			v-on:input="toggleActionButton($event)"
   			:items-per-page="5"
   			class="v-data-table--float-head">
		</v-data-table>
		<!--Action Modal-->
		<v-dialog v-model="actionModal" width="500" >
			  <template v-slot:activator="{ on }">
				  <v-btn 
					  v-show="actionBtnVisible" 
					  v-on="on" class="mx-2 action" fab dark large 
					  color="cyan"> <v-icon dark>mdi-pencil</v-icon>
				  </v-btn>
			  </template>

			  <v-card>
				<v-card-title class="headline grey lighten-2" primary-title >
					Ações
				</v-card-title>

				<v-card-text>
					<v-container>
						<v-row>
							<v-col class="d-flex" cols="12" sm="12">
								<v-btn color="primary" text @click="dispatchAction('defer')">Deferir</v-btn>
							</v-col>
						</v-row>
						<hr>
						<v-row>
							<v-col class="d-flex" cols="12" sm="3">
								<v-btn color="error" text @click="dispatchAction('deny')"> Indeferir </v-btn>
							</v-col>

							<v-col class="d-flex" cols="12" sm="9">
								<v-row no-gutters>
									<v-col cols="12" sm="12">
										<p>Selecione o motivo:</p>
									</v-col>
									<v-col cols="12" sm="12">
										<v-select 
						  					v-model="reasonToDeny"
			 								@change="reasonToDenySelected($event)"
											:items="reasonsToDeny" label="Solo field" dense solo ></v-select>
									</v-col>
									<v-col cols="12" sm="12">
										<v-textarea 
						  					v-show="reasonToDenyTextVisible"
						  					v-model="reasonToDenyText"
						  					outlined name="input-7-4" 
							   				label="Indeferido porque"
  											value="">
										</v-textarea>
									</v-col>
								</v-row>
							</v-col>

						</v-row>
					</v-container>
				</v-card-text>

				<v-divider></v-divider>


				<v-card-actions>
				  <v-spacer></v-spacer>
				  <v-btn color="primary" text @click="actionModal = false" >
					  Cancelar
				  </v-btn>
				</v-card-actions>
			  </v-card>
			</v-dialog>
	</v-app>
</template>

<style lang="scss">
	.v-application {
		background-color: transparent !important;
		font-size: 1.3rem;
		* {
			font-size:  inherit !important;
		}
		.v-data-footer {
			font-size:  1.1rem;
			* {
				font-size:  inherit !important;
			}
		}
		.v-icon:before {
			font-size: 2rem !important;
		}
		.v-input {
			width: 100%;
		}
		.date-picker--dual {
			margin-right: 1rem;
		}
		.v-list-item__title {
			line-height: 1.5rem !important;
		}
		
		.v-data-table {
			&--float-head {
				position: relative;
				//top: 1.8rem;

				.floatThead-container {
					overflow: hidden;
				}
				& .v-data-table-header {
					background-color:  #fff;
				}
			}
		}
	}
	.v-btn {
		&.action {
			$v-btn-action-size: 5.5rem;
			margin-left: 0 !important;
			width: $v-btn-action-size;
			height: $v-btn-action-size;
			position: fixed;
			left: calc(-#{$v-btn-action-size}/2);
			bottom: 2rem;
			transform: translateX(50vw);
		}
	}
	.filters {
		margin-bottom: 1.5rem;
		display: block;
		height: 3.6rem;

		.v-btn {
			float: right;
		}
	}
</style>

<script>
export default {
	data () {
		return {
			actionBtnVisible: false,
			showSelect: true,
			filtersModal: false,
			actionModal: false,
			reasonsToDeny: [],
			reasonToDenyText: '',
			reasonToDenyTextVisible: false,
			reasonToDeny: '',
			filters: { 
				available: [
					{ name: 'Nome', criteria: ['Igual a', 'Contém'], type: 'text'},
					{ name: 'CPF', criteria: ['Igual a', 'Contém'], type: 'text'},
					{ name: 'Matrícula', criteria: ['Igual a', 'Contém'], type: 'text'},
					{ name: 'Disciplina', criteria: ['Igual a'], type: 'select', values: []},
					{ name: 'Req.', criteria: ['Igual a'], type: 'select', values: ['Incluir', 'Excluir']},
					{ name: 'Motivo indef.', criteria: ['Igual a'], type: 'select',values: []},
					{ name: 'Data req.', criteria: ['Igual a', 'Entre', 'Antes de', 'Depois de'], type: 'date'},
					{ name: 'Resultado', criteria: ['Igual a'], type: 'select', values: []},
				],
				type: 'E',
				names: [],
				active: [],
			},
			headers: [
				{ text: '#',align: 'left',sortable: false,value: 'id' },
				{ text: 'Nome', value: 'student_name'},
				{ text: 'CPF', value: 'cpf'},
				{ text: 'Matrícula', value: 'enrolment_number'},
				{ text: 'Disciplina', value: 'subject_name'},
				{ text: 'Req.', value: 'action'},
				{ text: 'Motivo indef.', value: 'reason_denied'},
				{ text: 'Data req.', value: 'created_at'},
				{ text: 'Resultado', value: 'result'},
			],
			adjustments: [],
			dates: [],
			date: new Date().toISOString().substr(0, 10),
		}
	},
	watch: {
		filtersModal: function(newValue, oldValue) {
			this.fixFloatThead(newValue);
		},
		actionModal: function(newValue, oldValue) {
			this.fixFloatThead(newValue);
		}
	},
	mounted: function() {

		var $table = $('table');
		$table.floatThead();

		//Set repeating properties to available filters
		this.filters.available.forEach(filter => {
			filter.criteria_selected = 'Igual a';
			filter.value = '';
		});

		this.setColumnNames();

		this.addRow();

		//Column names for usage
		this.filters.names = this.filters.available.map(column => {
			return column.name});

		this.fetchAdjustments();


	},
	methods: {
		dispatchAction: function(decision) {
			this.actionModal = false;
			let adjustments = this.$refs['data-table'].selection;

			let reason = '';
			if(decision === 'deny' && this.reasonToDeny == 'Outro')
				reason = this.reasonToDenyText;
			else if(decision === 'deny') 
				reason = this.reasonToDeny;

			axios.post('servidor/adjustments/resolve', {adjustments, decision, reason})
				.then(response => {
					if(response.data.updated) {
						let ids = response.data.id;
						let result = response.data.result;
						let reason = response.data.reason;
						ids.map(id => {
							let adjustment = this.adjustments.filter(adjustment => {
								return adjustment.id === id;
							});
							adjustment[0].result = result;
							adjustment[0].reason_denied = reason;
						});
					}
				});
		},
		reasonToDenySelected: function(value) {
			this.reasonToDenyTextVisible = value === "Outro" ? true : false;
		},
		fixFloatThead: function(newValue) { 
			//Floating header fix z-index when dialog opens
			let floatTheadTable = $('.floatThead-container');
			if(newValue) floatTheadTable.css('z-index', 0); 
			else floatTheadTable.css('z-index', 1000);
		},
		toggleActionButton: function(event) {
			this.actionBtnVisible = event.length ? true : false;
		},
		
		fetchAdjustments: function(filters = null) {
			axios.get('servidor/adjustments/index', {params: {filters}})
				.then(response => {
					this.adjustments = response.data.adjustments;

					this.setFilterValues([
						{name: 'Disciplina', values: response.data.subjects},
						{name: 'Motivo indef.', values: response.data.reasons_denied},
						{name: 'Resultado', values: response.data.results},
					]);

					this.reasonsToDeny = response.data.reasons_to_deny;
					this.reasonToDeny = this.reasonsToDeny[0];
				});
		},
		getQuerySting: function(filtersActive) {
			let type = this.filters.type == 'E' ? 'and' : 'or';
			let esc = encodeURIComponent;
			let query = `type=${type}&`;

			filtersActive.map(row => {
				let colName = row.column_name;
				let value = (typeof row.value === 'object') ? 
					[esc(row.value[0]), esc(row.value[1])] : esc(row.value);

				switch(row.criteria_selected) {
					case "Igual a": query += `${colName}=${value}&`; break
					case "Contém": query += `${colName}[contains]=${value}&`; break
					case "Antes de": query += `${colName}[before]=${value}&`; break
					case "Depois de": query += `${colName}[after]=${value}&`; break
					case "Entre": query += `${colName}[after]=${value[0]}&${colName}[before]=${value[1]}&`; break
				}
			});
			return query.substring(0, query.length - 1);
		},
		applyFilters: function() {
			this.filtersModal = false;

			let filters = this.getQuerySting(this.filters.active);
			//console.log(filters);

			this.fetchAdjustments(filters);
		},
		removeFilters: function() {
			this.filtersModal = false;
			this.fetchAdjustments();
		},
		setColumnNames: function() {
			this.filters.available.map((filter, index) => {
				let changed = filter;
				let headerValue = this.headers.filter(header => {return header.text == filter.name})[0].value;
				changed.column_name = headerValue;
				Vue.set(this.filters.available, index, changed);
			});
		},
		filterChanged: function(value, index) {
			//Must alert to the row that a new column is selected and populate criteria
			let result = this.filters.available.filter(e => {return e.name == value});

			this.filters.active[index] = Object.assign(this.filters.active[index], result[0]);

			if(value === 'Data req.') {
				Vue.set(this.dates, index, {equals: false, start: false, end: false});
				this.criterionChanged('Igual a', index);
			}
			this.$forceUpdate();
		},
		criterionChanged: function(value, index) {
			let changed = this.filters.active[index];

			if(this.filters.active[index].name === 'Data req.') {
				let today = new Date().toISOString().substr(0, 10);
				if(value === 'Entre') {
					changed.value = [today, today];
				} else changed.value = today;
			}
			Vue.set(this.filters.active, index, changed);

			
		},
		
		addRow: function() {
			this.filters.active.push({ 
				name: 'Nome', 
				criteria: ['Igual a', 'Contém'], 
				type: 'text', 
				criteria_selected: 'Igual a',
				value: '',
				column_name: 'name',
			});
			let index = this.filters.active.length - 1; 
			this.filterChanged('Nome', index);
			this.criterionChanged('Igual a', index);
		},
		setFilterValues: function(data) {
			data.forEach(element => {
				let target = this.filters.available
					.filter(f => {return f.name === element.name})[0]
					.values = element.values;
			});
		}
	},
}
</script>
