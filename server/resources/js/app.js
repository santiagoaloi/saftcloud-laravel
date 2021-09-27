/* eslint-disable */
import Vue from "vue";

// Bootstrap
import "@/plugins";
import AOS from "aos";
import router from "@/router";
import { store } from "@/store";
import vuetify from "@/plugins/vuetify";

// Application
import App from "./App.vue";

// Animations

// Styles
import "aos/dist/aos.css";
import "./assets/css/style.css";

require("./bootstrap");

new Vue({
 created() {
  AOS.init({});
 },
 store,
 router,
 vuetify,
 render: h => h(App)
}).$mount("#app");
