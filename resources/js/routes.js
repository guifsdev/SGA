import VueRouter from 'vue-router';

let routes = [
	/*{
		path: '/',
		component: require('./views/Home.vue').default,
	},*/
	{
		name: 'Home',
		path: '/home',
		alias: '/',
		component: require('./views/Home.vue').default,
	},
	{
		name: 'Meus Dados',
		path: '/meus-dados',
		component: require('./views/MeusDados.vue').default,
	},
	{
		name: 'Ajuste',
		path: '/ajuste',
		component: require('./views/ajuste/Ajuste.vue').default,
	},
	{
		name: 'Certificados',
		path: '/certificados',
		component: require('./views/Certificados.vue').default,
	}
];




export default new VueRouter({
	routes
});