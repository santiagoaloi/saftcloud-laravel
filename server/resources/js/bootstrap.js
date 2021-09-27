/* eslint-disable */

import axios from "axios";
import router from "@/router";
import { store } from "@/store";

const axiosDefaults = require("axios/lib/defaults");
const csrf = document.head.querySelector('meta[name="csrf-token"]');

axiosDefaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axiosDefaults.headers.common["X-CSRF-TOKEN"] = csrf.content;

// Awaits for storage (indexedDB) to be ready.
const getToken = async () => {
 await store.restored;
 return store.get("authentication@session.token");
};

getToken().then(sessionToken => {
 if (sessionToken) {
  axiosDefaults.headers.common.Authorization = `Bearer ${sessionToken}`;
 }
});

// Attaches catch to every axios request
axios.interceptors.response.use(
 response => response,
 error => {
  if (error.response) {
   // If session fails to validate the token, kill the session.
   if (error.response.data.message === "Unauthenticated.") {
    router.push("/login");
    store.set("authentication/session", {});
   }

   // If records are duplicated
   if (error.response.data.code === 1062) {
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Duplicated records, try choosing a different value");
    store.set("snackbar/color", "pink darken-1");
   }

   return Promise.reject(error);
  }
 }
);
