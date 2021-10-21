/* eslint-disable */
import Vue from 'vue';

// Bootstrap
import '@/plugins';
require('./bootstrap');
import AOS from 'aos';
import router from '@/router';
import { store } from '@/store';
import vuetify from '@/plugins/vuetify';

//Role privileges

import Privileges from './mixins/Privileges';

// Application
import App from './App.vue';

// Styles
import 'aos/dist/aos.css';
import './assets/css/style.css';

import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px',
});

// Vue.mixin(Privileges);

new Vue({
  created() {
    AOS.init({});
  },
  store,
  router,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
