import VueRouter from 'vue-router';

let routes = [
	//{
		//name: 'Login',
		//path: '/login',
		//component: require('./views/Login.vue').default,
	//},
	{
		name: 'Home',
		path: '/estudante',
		alias: '/',
		component: require('./views/student/Home.vue').default,
	},
	{
		name: 'Meus Dados',
		path: '/meus-dados',
		component: require('./views/student/MyData.vue').default,
	},
	{
		name: 'Ajuste',
		path: '/ajuste',
		component: require('./views/student/adjustment/Adjustment.vue').default,
	},
	{
		name: 'Certificados',
		path: '/certificados',
		component: require('./views/student/Certificates.vue').default,
	},
	{
		name: 'Eventos',
		path: '/eventos',
		component: require('./views/Eventos.vue').default,
	},
	{
		name: 'Resoler ajustes',
		path: '/resolver-ajustes',
		component: require('./views/servant/ResolveAdjustment.vue').default,
	},
	{
		name: 'Configurações',
		path: '/configs',
		component: require('./views/servant/Configuration.vue').default,
	},
	{
		name: 'Chamados',
		path: '/chamados',
		component: require('./views/servant/Calls.vue').default,
	},
];




export default new VueRouter({
	routes
});
