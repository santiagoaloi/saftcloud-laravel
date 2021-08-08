import Vue from "vue";

// Bootstrap
require("./bootstrap");
import "@/plugins";
import router from "@/router";
import { store } from "@/store";
import vuetify from "@/plugins/vuetify";

// Application
import App from "./App.vue";

//Animations
import AOS from "aos";

// Styles
import "aos/dist/aos.css";
import "../sass/theme.scss";
import "./assets/css/style.css";

//Layouts
Vue.component("login_layout", () => import(/* webpackChunkName: 'login-Layout' */ "@/layouts/loginLayout/Index"));
Vue.component("public_layout", () => import(/* webpackChunkName: 'public-Layout' */ "@/layouts/publicLayout/Index"));
Vue.component("secure_layout", () => import(/* webpackChunkName: 'public-Layout' */ "@/layouts/secureLayout/Index"));

new Vue({
 store,
 router,
 vuetify,
 created() {
  AOS.init({});
 },
 render: h => h(App)
}).$mount("#app");
