import { store } from "@/store";

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// If no token exists in VUEX, don't set the token bearer in header.
let token = store.get("authentication@session.token");

if (token != undefined) {
  window.axios.defaults.headers = {
    "Content-Type": "application/json",
    Authorization: "Bearer " + token
  };
}
