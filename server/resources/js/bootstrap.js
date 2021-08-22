import { store } from "@/store";
import axios from "axios";
import router from "@/router";

const axiosDefaults = require("axios/lib/defaults");
let csrf = document.head.querySelector('meta[name="csrf-token"]');
axiosDefaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axiosDefaults.headers.common["X-CSRF-TOKEN"] = csrf.content;

//Awaits for storage (indexedDB) to be ready.
let getToken = async () => {
 await store.restored;
 return store.get("authentication@session.token");
};

getToken().then(sessionToken => {
 if (sessionToken) {
  axiosDefaults.headers.common["Authorization"] = "Bearer " + sessionToken;
 }
});

axios.interceptors.response.use(
 response => {
  return response;
 },
 function(error) {
  if (error.response && error.response.data.message === "Unauthenticated.") {
   router.push("/login");
   store.set("authentication/session", {});
  }
  return Promise.reject(error);
 }
);
