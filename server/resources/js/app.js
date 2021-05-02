/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// import vuetify from './vuetify';

import "@/plugins";
import App from "@/App.vue";
import router from "@/router";
import { store } from "@/store";
import vuetify from "@/plugins/vuetify";

import AOS from "aos";
import "aos/dist/aos.css";

// Main Theme SCSS
// import "./assets/scss/theme.scss";
import "./assets/css/style.css";

Vue.component("public_layout", () => import("@/layouts/publicLayout/Index"));


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('articulo', require('./components/Articulo.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    created() {
      AOS.init({});
    },
    store,
    router,
    vuetify,
    render: (h) => h(App),
  }).$mount("#app");
