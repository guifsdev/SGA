import './bootstrap';
import Login from './views/Login.vue';
import Home from './views/Home.vue';


import vuetify from './plugins/vuetify'; // path to vuetify export
import routes from './routes.js';

const app = new Vue({
  el: '#app',
  vuetify,
  router: routes,
  components: {Login, Home},
});
