import { store } from "@/store";
const axiosDefaults = require("axios/lib/defaults");
let csrf = document.head.querySelector('meta[name="csrf-token"]');
axiosDefaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axiosDefaults.headers.common["X-CSRF-TOKEN"] = csrf.content;

//Awaits for storage to be ready.
let getToken = async () => {
 await store.restored;
 return store.get("authentication@session.token");
};

getToken().then(sessionToken => {
 if (sessionToken) {
  axiosDefaults.headers.common["Authorization"] = "Bearer " + sessionToken;
 }
});
