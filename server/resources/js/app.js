/* eslint-disable */
import Vue from 'vue';

// Bootstrap
import '@/plugins';
require('./bootstrap');
import router from '@/router';
import { store } from '@/store';
import vuetify from '@/vuetify';

Vue.config.devtools = true;

// Application
import App from './App.vue';

// Styles amd Animations
import AOS from 'aos';
import 'aos/dist/aos.css';
import './assets/css/style.css';

// Role based access
import Privileges from './mixins/privileges';

vuetify().then((v) => {
  const vuetify = v;
  new Vue({
    mixins: [Privileges],
    created() {
      AOS.init();
    },
    store,
    router,
    vuetify,
    render: (h) => h(App),
  }).$mount('#app');
});
