import './bootstrap';

//import ActiveStudentsUpdater from './components/ActiveStudentsUpdater.vue'; 
//import EventList from './components/events/EventList.vue'; 
//import EventEdit from './components/events/EventEdit.vue'; 
//import EventCreate from './components/events/EventCreate.vue';
//import Event from './components/events/Event.vue';

//import CertificatesEmit from './components/certificados/CertificatesEmit.vue';
//import CertificatesList from './components/certificados/CertificatesList.vue'; 
//import CertificatesValidator from './components/certificados/CertificatesValidator.vue'; 

//import CreateUsers from './components/usuarios/CreateUsers.vue'; 

import Login from './views/Login.vue';


import vuetify from './plugins/vuetify'; // path to vuetify export
import routes from './routes.js';

const app = new Vue({
    el: '#app',
	vuetify,
    router: routes,
	components: {Login},
});
