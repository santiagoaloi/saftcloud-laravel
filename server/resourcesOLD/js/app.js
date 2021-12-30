/* eslint-disable */
import Vue from 'vue';

// Bootstrap
import '@/plugins';
require('./bootstrap');
import router from '@/router';
import { store } from '@/store';
import vuetify from '@/vuetify';

Vue.config.devtools = true;

// Layouts
Vue.component('SecureLayout', () => import(/* webpackChunkName: 'secure-layout' */ '@/layouts/secureLayout/Index.vue'));
Vue.component('PublicLayout', () => import(/* webpackChunkName: 'public-layout' */ '@/layouts/publicLayout/Index.vue'));
Vue.component('NotFoundLayout', () => import(/* webpackChunkName: 'not-found-layout' */ '@/layouts/notFoundLayout/Index.vue'));

// Application
import App from './App.vue';

//flags
import CountryFlag from 'vue-country-flag';
Vue.component('country-flag', CountryFlag);

//Fragment
import Fragment from 'vue-fragment';
Vue.use(Fragment.Plugin);

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
    vuetify,
    router,
    render: (h) => h(App),
  }).$mount('#app');
});
