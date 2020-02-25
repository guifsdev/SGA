<template>
	<v-app>
		<div class="filters">
			<v-dialog v-model="dialog" width="600">
				<template v-slot:activator="{ on }">
					<v-btn v-on="on">Filtrar colunas</v-btn>
				</template>

				<v-card>
					<v-card-title class="headline grey lighten-2" primary-title>Filtrar colunas</v-card-title>
					<v-card-text>
						<v-container fluid class="filters-container">
							<v-row 
								v-for="(column, index) in filters.active"
								:key="index"
								align="center" 
								no-gutters>	
								<v-col no-gutters class="d-flex" cols="12" sm="4">
									<v-select 
										v-bind:value="column.name"
										:items="filters.names" 
										@change="filterSelected($event, index)" dense solo></v-select>
								</v-col>

								<v-col 
								no-gutters class="d-flex" cols="12" sm="3">
									<v-select
										v-bind:value="column.criteria[0]"
										:key="filters.reload"
										:items="column.criteria"
										dense solo></v-select>
								</v-col>

								<v-col no-gutters class="d-flex no-gutters--inline" cols="12" sm="5" >
									<v-text-field 
										v-if="column.type == 'text'"
										:label="column.name" dense></v-text-field>
									<v-select 
		  								v-if="column.type == 'select'"
										class=""
										:items="column.values" dense solo></v-select>
								</v-col>
							</v-row>
						</v-container>
						<v-btn class="mx-2" fab dark color="primary" x-small @click="addFilter">
							<v-icon dark>mdi-plus</v-icon>
						</v-btn>
					</v-card-text>

					<v-divider></v-divider>

					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="primary" text @click="dialog = false">Aplicar filtros</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</div>

		<v-data-table
			:headers="headers"
			:items="adjustments"
			:show-select="showSelect"
			:multi-srot="true"
			item-key="id"
   			:items-per-page="5"
   			class="v-data-table--float-head">
		</v-data-table>
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

		.col-12:not(:last-child) {
			margin-right: 1rem;
		}
		.no-gutters--inline {
			max-width: 37.5%;
		}
		.v-list-item__title {
			line-height: 1.5rem !important;
		}
		.v-data-table {
			&--float-head {
				position: relative;
				//top: 1.8rem;

				.floatThead-container {
					z-index: initial !important;
					overflow: hidden;
				}
				& .v-data-table-header {
					background-color:  #fff;
				}
			}
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
			showSelect: true,
			dialog: false,
			filters: { 
				available: [
					{ name: 'Nome', criteria: ['Igual a', 'Contém'], type: 'text', },
					{ name: 'CPF', criteria: ['Igual a', 'Contém'], type: 'text', },
					{ name: 'Matrícula', criteria: ['Igual a', 'Contém'], type: 'text'},
					{ name: 'Disciplina', criteria: ['Igual a'], type: 'select', values: []},
					{ name: 'Req.', criteria: ['Igual a'], type: 'select', values: ['Incluir', 'Excluir']},
					{ name: 'Motivo indef.', criteria: ['Igual a'], type: 'select',values: []},
					{ name: 'Data req.', criteria: ['Igual a', 'Entre', 'Antes de', 'Depois de'], type: 'date'},
					{ name: 'Resultado', criteria: ['Igual a'], type: 'select', values: ['Deferido', 'Indeferido']},
				],
				names: [],
				active: [],
				reload: true,
			},
			headers: [
				{ text: '#',align: 'left',sortable: false,value: 'id' },
				{ text: 'Nome', value: 'student_name'},
				{ text: 'CPF', value: 'cpf'},
				{ text: 'Matrícula', value: 'enrolment_number'},
				{ text: 'Disciplina', value: 'subject_name'},
				{ text: 'Req.', value: 'action'},
				{ text: 'Motivo indef.', value: 'reason_deny'},
				{ text: 'Data req.', value: 'created_at'},
				{ text: 'Resultado', value: 'result'},
			],
			adjustments: [],
		}
	},
	mounted: function() {
		
		var $table = $('table');
		$table.floatThead();
	
		this.addFilter();

		this.filters.names = this.filters.available.map(column => {return column.name});

		axios.get('servidor/adjustment/index')
			.then(response => {
				this.adjustments = response.data;
			});
	},
	methods: {
		// getAvailableFilters: function() {
		// 	return this.headers.filter(column => {
		// 		return column.value != 'id';
		// 	}).map(column => { 
		// 		this.colNames.push(column.text);
		// 		return {name: column.text, filter: column.filter} 
		// 	});
		// },
		filterSelected: function(value, index) {
			//Must alert to the row that a new column is selected and populate criteria
			let result = this.filters.available.filter(e => {return e.name == value});

			this.filters.active[index] = result[0];
			
			this.filters.reload = this.filters.reload ? false : true;
		},

		addFilter: function() {
			let filter = { name: 'Nome', criteria: ['Igual a', 'Contém'], type: 'text'}
			this.filters.active.push(filter);
		},
	},
}
</script>
