/* eslint-disable */
import Vue from 'vue';

// Bootstrap
import '@/plugins';
require('./bootstrap');
import AOS from 'aos';
import router from '@/router';
import { store } from '@/store';
import vuetify from '@/plugins/vuetify';

// Role based access
import Privileges from './mixins/privileges';

// Application
import App from './App.vue';

// Styles
import 'aos/dist/aos.css';
import './assets/css/style.css';

new Vue({
  mixins: [Privileges],
  created() {
    AOS.init({});
  },
  store,
  router,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
