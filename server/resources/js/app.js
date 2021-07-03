require("./bootstrap");

import Vue from "vue";
import App from "./App.vue";

import "@/plugins";
import router from "@/router";
import { store } from "@/store";
import vuetify from "@/plugins/vuetify";

import AOS from "aos";
import "aos/dist/aos.css";

import VueDiagonal from "vue-diagonal";
Vue.component("vue-diagonal", VueDiagonal);

// STYLES
import "../sass/theme.scss";
import "./assets/css/style.css";

Vue.component("login_layout", () => import(/* webpackChunkName: 'Login-Layout' */ "@/layouts/loginLayout/Index"));
Vue.component("public_layout", () => import(/* webpackChunkName: 'Public-Layout' */ "@/layouts/publicLayout/Index"));
Vue.component("secure_layout", () => import(/* webpackChunkName: 'Public-Layout' */ "@/layouts/secureLayout/Index"));

new Vue({
 store,
 vuetify,
 router,
 created() {
  AOS.init({});
 },
 render: h => h(App)
}).$mount("#app");
