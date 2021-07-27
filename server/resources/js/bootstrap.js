import { store } from "@/store";
const axiosDefaults = require("axios/lib/defaults");

// If no token exists in VUEX, don't set the token bearer in header.
let token = store.get("authentication@session.token");

let csrf = document.head.querySelector('meta[name="csrf-token"]');

axiosDefaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axiosDefaults.headers.common["X-CSRF-TOKEN"] = csrf.content;
axiosDefaults.headers.common["Authorization"] = "Bearer " + token;
