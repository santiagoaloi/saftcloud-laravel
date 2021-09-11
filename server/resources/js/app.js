import Vue from "vue";

// Bootstrap
import "@/plugins";
require("./bootstrap");
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
Vue.component("public_layout", () => import(/* webpackChunkName: 'public-Layout' */ "@/layouts/publicLayout/Index"));
Vue.component("secure_layout", () => import(/* webpackChunkName: 'secure-Layout' */ "@/layouts/secureLayout/Index"));

new Vue({
 created() {
  AOS.init({});
 },
 store,
 router,
 vuetify,
 render: h => h(App)
}).$mount("#app");
