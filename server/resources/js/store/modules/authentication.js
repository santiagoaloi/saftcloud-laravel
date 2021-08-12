// Utilities
import axios from "axios";
import router from "@/router";
import { make } from "vuex-pathify";
const axiosDefaults = require("axios/lib/defaults");

const state = {
 session: {}
};

const mutations = make.mutations(state);

const actions = {
 ...make.actions(state),

 //Sends login form payload to backend.
 async login({ commit }, data) {
  return axios
   .post("api/login", data)
   .then(response => {
    if (response.status === 200) {
     commit("session", response.data.data);
     axiosDefaults.headers.common["Authorization"] = `Bearer ${response.data.data.token}`;
     return true;
    } else {
     return false;
    }
   })
   .catch(_ => {
    return false;
   });
 },

 //Logs out the user.
 logout({ commit }, data) {
  return axios
   .post("api/logout", data)
   .then(response => {
    if (response.status === 200) {
     axiosDefaults.headers.common["Authorization"] = undefined;
     commit("session", {});
     router.push("/login");
     return true;
    } else {
     commit("session", {});
     router.push("/login");
     return false;
    }
   })
   .catch(_ => {
    commit("session", {});
    router.push("/login");
    return false;
   });
 }
};

const getters = {};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
