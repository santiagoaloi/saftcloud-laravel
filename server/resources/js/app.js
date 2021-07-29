require("./bootstrap");

import "@/plugins";
import Vue from "vue";
import AOS from "aos";
import App from "./App.vue";
import router from "@/router";
import { store } from "@/store";
import vuetify from "@/plugins/vuetify";

// styles
import "aos/dist/aos.css";
import "../sass/theme.scss";
import "./assets/css/style.css";

Vue.component("login_layout", () => import(/* webpackChunkName: 'login-Layout' */ "@/layouts/loginLayout/Index"));
Vue.component("public_layout", () => import(/* webpackChunkName: 'public-Layout' */ "@/layouts/publicLayout/Index"));
Vue.component("secure_layout", () => import(/* webpackChunkName: 'public-Layout' */ "@/layouts/secureLayout/Index"));

new Vue({
 store,
 vuetify,
 router,
 created() {
  AOS.init({});
 },
 render: h => h(App)
}).$mount("#app");
