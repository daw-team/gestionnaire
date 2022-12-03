import './bootstrap';

import Vue from 'vue'
import App from './App.vue'

import VueRouter from 'vue-router'
import { routes } from './routes'


import VueSweetalert2 from 'vue-sweetalert2';


import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);


// Vue.config.productionTip = false
const router = new VueRouter({
    routes,
    mode: 'history',
})

Vue.use(VueRouter);

new Vue({router,
  render: h => h(App),
}).$mount('#app')


