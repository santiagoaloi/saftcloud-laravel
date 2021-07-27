import { store } from "@/store";

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// If no token exists in VUEX, don't set the token bearer in header.
let token = store.get("authentication@session.token");
let csrf = document.head.querySelector('meta[name="csrf-token"]');

// console.log(csrf.content);
window.axios.defaults.headers.common["X-CSRF-TOKEN"] = csrf.content;
axios.defaults.headers.common["Authorization"] = "Bearer " + token;
